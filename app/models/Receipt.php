<?php

class Receipt extends \Eloquent {

	// Don't forget to fill this array    
	protected $table = 'receipts';
	protected $fillable = ['to_email','to_firstname','to_lastname','data','date_paid','tax','subtotal','user_id'];

	public static function getReceipts($user_id) {
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
    
    public static function countReceiptsForDate($user_id, $start_date, $end_date){
        $sql = "select count(*) as num_receipts from receipts where user_id = :user_id and ";
        $sql .= "created_at between :start_date and :end_date";
        return DB::select(
                DB::raw($sql),
                [
                    'user_id' => $user_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );
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
