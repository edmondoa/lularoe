<?php

class Receipt extends \Eloquent {

	// Don't forget to fill this array    
	protected $table = 'receipts';
	protected $fillable = ['to_email','to_firstname','to_lastname','data','date_paid','tax','subtotal','user_id'];

	public static function getReceipts($user_id = '') {
		if (empty($user_id)) $user_id = Auth::user()->id;
		return(Receipt::where('user_id',$user_id)->orderBy('created_at','desc')->get());
	}

	public function ledger() {
		return $this->hasMany('Ledger');
	}

    public function address() {
        return $this->belongsTo('Address');
    }

    public function receipt() {
        return $this->belongsTo('User');
    }
    
	public static function chartable($user_id = '') {
		if (empty($user_id)) $user_id = Auth::user()->id;

		$sql	= "SELECT id,data,DATE_FORMAT(created_at,'%Y-%m-%d') as ca,tax,subtotal FROM receipts WHERE user_id=:user_id";
        $rd 	= DB::select(DB::raw($sql), [ 'user_id' => $user_id, ]);

		$itemdata = [];
		foreach($rd as $r) {
			$items			= json_decode($r->data);
			foreach($items as $item) {
				$sizeandquant = (array)$item->quantities;
				$size 	= key($sizeandquant);
				$quant	= array_shift($sizeandquant);

				$shortname = strtoupper($item->model);
				$itemname = strtoupper("{$shortname} {$size}");
				@$itemdata[$r->ca][$itemname]['total'] += ($quant * $item->price);
				@$itemdata[$r->ca][$itemname]['count'] += $quant;

				@$sellers[$r->ca][$shortname]['total'] += ($quant * $item->price);
				@$sellers[$r->ca][$shortname]['count'] += $quant;

				@$uniqueitems[$itemname] += 1;
			}
		}

		$uniqueitems = array_keys($sellers);
	
        $queries = DB::getQueryLog();
        \Log::info(__FILE__.'@'.__LINE__.' > LAST QUERY: '.print_r(end($queries),true));

		$sql="SELECT DATE_FORMAT(ledger.created_at,'%Y-%m-%d') AS `DATE`,UNIX_TIMESTAMP(ledger.created_at) `TS`,receipt_id RECEIPT_ID,SUM(CASE WHEN ledger.txtype='CASH' THEN ledger.amount ELSE 0 END) AS CASH, SUM(CASE WHEN ledger.txtype='CASH' THEN ledger.tax ELSE 0 END) AS TAX_CASH, SUM(CASE WHEN ledger.txtype='CARD' THEN ledger.amount ELSE 0 END) AS CARD, SUM(CASE WHEN ledger.txtype='CARD' THEN ledger.tax ELSE 0 END) AS TAX_CARD,SUM(ledger.amount) AS SUBTOTAL,sum(ledger.tax) AS TAX_TOTAL,sum(ledger.tax+ledger.amount) AS TOTAL FROM ledger WHERE ledger.user_id=:user_id AND ledger.created_at > '2015-04-05' GROUP BY receipt_id ORDER BY ledger.created_at ASC";
        $sales = DB::select(DB::raw($sql), [ 'user_id' => $user_id, ]);

		foreach($sales as $sale) { 
			@$salesdata[$sale->DATE]['items'][] 	= $sale;
			@$salesdata[$sale->DATE]['tax'] 		+= $sale->TAX_TOTAL;
			@$salesdata[$sale->DATE]['subtotal']	+= $sale->SUBTOTAL;
			@$salesdata[$sale->DATE]['total']		+= $sale->SUBTOTAL+$sale->TAX_TOTAL;
		} 
		
        $queries = DB::getQueryLog();
        \Log::info(__FILE__.'@'.__LINE__.' > LAST QUERY: '.print_r(end($queries),true));

		return array('uniqueitems'=>$uniqueitems,'items'=>$itemdata,'sales'=>$salesdata,'sellers'=>$sellers);
	}

    public static function countReceiptsForDate($user_id, $start_date, $end_date){
        $sql = "select count(*) as num_receipts from receipts where user_id = :user_id and ";
        $sql .= "created_at between :start_date and :end_date";
        $res = DB::select(
                DB::raw($sql),
                [
                    'user_id' => $user_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

        $queries = DB::getQueryLog();
        \Log::info(__FILE__.'@'.__LINE__.' > LAST QUERY: '.print_r(end($queries),true));
		
		return $res;
    }
    
    public static function sumAmountForDate($user_id, $start_date, $end_date){
        $sql = "select sum(amount) as sum_amount, sum(tax) as sum_tax from receipts where user_id = :user_id and ";
        $sql .= ($start_date == $end_date) ? "date_format(created_at,'%Y-%m-%d')" : "created_at";
        $sql .= " between :start_date and :end_date";
        return DB::select(
                DB::raw($sql),
                [
                    'user_id' => $user_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );
    }

}
