<?php

class ReportController extends \BaseController {

/*
	Route::get('reports', 'ReportController@index');
	Route::get('api/report-sales/{id}', 'ReportController@getReportSales');
	Route::get('api/report-inventory/{id}', 'ReportController@getReportInventory');
*/
	public function index($id = '')
	{
		if (Auth::user()->hasRole(['Superadmin','Admin'])) { 
			Session::flash('ledgerUserId',$id);
			$id = Auth::user()->id;
		}
		$ledgerlist = Ledger::getLedgers($id);
		
		$ytd = $this->getDatesYTD();
		$temp = $ytd;
		$ytd = array();
		foreach($temp as $day){
			$query_month = strtotime('+1 month',strtotime($day));
			$ytd[date('Y-m-d',$query_month)] = date('M Y',strtotime($day));
		}
		
		return View::make('reports.index',compact('ledgerlist','ytd'));
	}

	public function sales($id = '')
	{
		if (Auth::user()->hasRole(['Superadmin','Admin'])) { 
			Session::flash('ledgerUserId',$id);
		}
		else $id = Auth::user()->id;

		return View::make('reports.sales', compact('orderlist'));
	}

	public function orders($id = '')
	{
		if (Auth::user()->hasRole(['Superadmin','Admin'])) { 
			Session::flash('ledgerUserId',$id);
		}
		else $id = Auth::user()->id;
		$orderlist = Receipt::getReceipts($id);

/*     
		$dates = $this->getMondaysEveryWeek(date('Y-m-d'),date('Y-m-d'));
		
		$rdb = Receipt::countReceiptsForDate($id,$dates[0],$dates[1]);

		$ytd = $this->getDatesYTD();
		$temp = $ytd;
		$ytd = array();
		foreach($temp as $day){
			$query_month = strtotime('+1 month',strtotime($day));
			$ytd[date('Y-m-d',$query_month)] = date('M Y',strtotime($day));
		}
		$daily = $this->getDailyDatesFromRange("2015-04-07",date('Y-m-d'));
*/
		$queries = DB::getQueryLog();
		$last_query = end($queries);
		\Log::info('LAST QUERY: '.print_r($last_query,true));

		//return Response::json($orderlist);
		//return View::make('reports.orders', compact('orderlist','dates','rdb','ytd','daily'));
		return View::make('reports.orders', compact('orderlist'));
	}

	public function getChartable($id = '') {
		$user_id = Session::has('ledgerUserId') ? Session::get('ledgerUserId') : Auth::user()->id;
		return Response::json(Receipt::chartable($user_id),200,[],JSON_PRETTY_PRINT);
	}
	
	public function getLedgerDatesWithRecord($month){
		$id = '0';
		if (Auth::user()->hasRole(['Superadmin','Admin'])) { 
			Session::flash('ledgerUserId',$id);
			$id = Auth::user()->id;
		}
		
		$end_date = $month;
		$start_date = strtotime('-1 month', strtotime($end_date));
		$start_date = date('Y-m-d',$start_date);
		
		$res = Ledger::getDatesWithRecord($id, $start_date, $end_date);
		
		$dates = array();
		
		foreach($res as $d){
			$dd = date('Y-m-d',strtotime($d->created_at));
			$amount = Ledger::sumAmountForDate($id, $dd, $dd);
			$amount = current($amount);
			$num_count = Ledger::countLedgerForDate($id,$dd,$dd);
			$num_count = current($num_count);
			$dates[] = array(
						'date'=> $dd,
						'amount' => $amount->sum_amount,
						'tax' => $amount->sum_tax,
						'items' => $num_count->num_ledger
					);
		}
		
		$output = array(
			'count' => count($dates),
			'data' => $dates
		);
		return Response::json($output);
	}
	
	public function getLedgerWithDate($month){
		$id = '0';
		if (Auth::user()->hasRole(['Superadmin','Admin'])) { 
			Session::flash('ledgerUserId',$id);
			$id = Auth::user()->id;
		}
		
		$res = Ledger::getLedgerWithDate($id, $month, $month);
		
		$output = array(
			'count' => count($res),
			'data' => $res
		);
		
		return Response::json($output,200,[], JSON_PRETTY_PRINT);
	}
	
	public function getSalesMetrics($option){
		$month = Input::get('m');
		$data = array();
		$categories = array();
		$volume = array();
		$output = array();
		$subtitle = "";
		$xorientation = "rotate";
		$user_id = Session::has('ledgerUserId') ? Session::get('ledgerUserId'): 0;
		switch($option){
			case 'ytd':
				$subtitle = "Year-To-Date";
				$cat = $this->getDatesYTD();
				$categories = array_reverse($cat);
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Ledger::countLedgerForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_ledger;
					$curd = $n;     
				}
				
				break;
			case 'monthly':
				if(empty($month)){
					$start_date = date('Y-m-'.'01');
					$end_date = strtotime('+1 month',strtotime($start_date));
					$end_date = date('Y-m-d',$end_date);
				}else{
					$end_date = $month;
					$start_date = strtotime('-1 month', strtotime($end_date));
					$start_date = date('Y-m-d',$start_date);
				}

				$categories = $this->getDailyDatesFromRange($start_date,$end_date);
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Ledger::countLedgerForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_ledger;
					$curd = $n;     
				}
				
				$subtitle = "Month of ";
				$subtitle .= empty($month) ? date('F, Y') : date('F, Y',strtotime($start_date));
				break;
				
			case 'weekly':
				$xorientation = "norotate";
				$categories = $this->getMondaysEveryWeek(date('Y-m-d'),date('Y-m-d'));
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Ledger::countLedgerForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_ledger;
					$curd = $n;     
				}
				$x = 0;
				$temp = $categories;
				$categories = array();
				foreach($temp as $i=>$c){
					$categories[] = "Week ".($i+1)." <br/>".$c;
				}

				$subtitle = "Month of ".date('F, Y');
				break;
				
			case 'daily':
				$start_date = date('Y-m-d 00:00:00');
				$end_date = strtotime('+1 day',strtotime($start_date));
				for($i = strtotime($start_date); $i <= $end_date; $i = strtotime('+1 hour', $i)){
					$categories[] = date('Y-m-d H:i:s', $i);
				}
				
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Ledger::countLedgerForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_ledger;
					$curd = $n;     
				}
				
				$x = 0;
				$temp = $categories;
				$categories = array();
				foreach($temp as $i=>$c){
					$categories[] = date('H:i',strtotime($c));
				}
				
				$subtitle = date('F d, Y');
				break;
				
		}
		
		$data['name'] = "Count";
		$data['data'] = $volume;
		
		$output[] = $data;
		
		return Response::json(array('data'=>$output,'subtitle'=>$subtitle,'xorientation'=>$xorientation,'categories'=>$categories,'count'=>count($volume)),200,[], JSON_PRETTY_PRINT);
	}
	
	public function getMetrics($option){
		$data = array();
		$categories = array();
		$volume = array();
		$output = array();
		$subtitle = "";
		$xorientation = "rotate";
		$user_id = Session::has('ledgerUserId') ? Session::get('ledgerUserId'): Auth::user()->id;
		switch($option){
			case 'ytd':
				$subtitle = "Year-To-Date";
				$cat = $this->getDatesYTD();
				$categories = array_reverse($cat);
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Receipt::countReceiptsForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_receipts;
					$curd = $n;     
				}
				
				break;
			case 'monthly':
				$start_date = date('Y-m-'.'01');
				$end_date = strtotime('+1 month',strtotime($start_date));
				$end_date = date('Y-m-d',$end_date);
				$categories = $this->getDailyDatesFromRange($start_date,$end_date);
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Receipt::countReceiptsForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_receipts;
					$curd = $n;     
				}
				
				$subtitle = "Month of ".date('F, Y');
				break;
			case 'weekly':
				$xorientation = "norotate";
				$categories = $this->getMondaysEveryWeek(date('Y-m-d'),date('Y-m-d'));
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Receipt::countReceiptsForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_receipts;
					$curd = $n;     
				}
				$x = 0;
				$temp = $categories;
				$categories = array();
				foreach($temp as $i=>$c){
					$categories[] = "Week ".($i+1)." <br/>".$c;
				}

				$subtitle = "Month of ".date('F, Y');
				break;
			case 'daily':
				$start_date = date('Y-m-d 00:00:00');
				$end_date = strtotime('+1 day',strtotime($start_date));
				for($i = strtotime($start_date); $i <= $end_date; $i = strtotime('+1 hour', $i)){
					$categories[] = date('Y-m-d H:i:s', $i);
				}
				
				@reset($categories);
				$curd = current($categories);
				while($curd && $n = next($categories)){
					$val = Receipt::countReceiptsForDate($user_id,$curd,$n);
					$res = current($val);
					$volume[] = (int)$res->num_receipts;
					$curd = $n;     
				}
				
				$x = 0;
				$temp = $categories;
				$categories = array();
				foreach($temp as $i=>$c){
					$categories[] = date('H:i',strtotime($c));
				}
				
				$subtitle = date('F d, Y');
				break;
		}
		
		$data['name'] = "Orders Received";
		$data['data'] = $volume;
		
		$output[] = $data;
		
		return Response::json(array('data'=>$output,'subtitle'=>$subtitle,'xorientation'=>$xorientation,'categories'=>$categories,'count'=>count($volume)),200,[], JSON_PRETTY_PRINT);
	}
	
	public function getDailyDatesFromRange($start_date, $end_date)
	{
		$start_date = strtotime($start_date);
		$end_date = strtotime($end_date);
		
		$dates = array();
		
		for($i = $start_date; $i <= $end_date; $i = strtotime('+1 day', $i)){
			$dates[] = date('Y-m-d', $i);
		}
		
		return $dates;
	}
	
	public function getDatesYTD()
	{
		$dates = array();
		$start_date = strtotime(date('Y-m-'.'01'));
		
		for($i = strtotime('+1 month',$start_date); count($dates) <= 12; $i = strtotime('-1 month', $i)){
			$dates[] = date('Y-m-d', $i);
		}
		
		return $dates;
	}
	
	public function getMondaysEveryWeek($start_date, $end_date, $span="-1 month")
	{
		$i = strtotime('Monday', strtotime($start_date));
		$start_date = strtotime($span, $i);

		$start_date = date('Y-m-d', $start_date);
		$end_date = strtotime('+1 week',strtotime($end_date));
		
		$dates = array();
		
		for($i = strtotime('Monday', strtotime($start_date)); $i <= $end_date; $i = strtotime('+1 week', $i)){
			$dates[] = date('Y-m-d', $i);
		}
		
		return $dates;
	}

	public function getReportReceipts() {
		if (Session::has('ledgerUserId')) $user = User::find(Session::get('ledgerUserId'));
		else $user = Auth::user();

		$receipts = Receipt::where('user_id',$user->id)->orderBy('created_at','asc')->get();

		return Response::json(array('data'=>$receipts,'count'=>count($receipts)),200,[], JSON_PRETTY_PRINT);
	}

	public function getOrderList() {
		if (Session::has('ledgerUserId')) $id = Session::get('ledgerUserId');
		else $id = Auth::user()->id;

		$orderlist = App::make('ExternalAuthController')->getReceipts($id);
		return Response::json(array('data'=>$sales,'count'=>count($sales)),200,[], JSON_PRETTY_PRINT);
	}

	public function getReportSales() {
		if (Session::has('ledgerUserId')) $id = Session::get('ledgerUserId');
		else $id = Auth::user()->id;

		$sales = App::make('ExternalAuthController')->getLedger($id);

		return Response::json(array('data'=>$sales,'count'=>count($sales)),200,[], JSON_PRETTY_PRINT);
	}

	public function getReportInventory($id = '') {
		return Response::json(null,200);
	}

	public function TransactionsByUser($repId)
	{
		if(is_null($repId)) $repId = Auth::user()->id;
		$consultant = User::find($repId);
		$transactions = [];
		$sql = "
			SELECT	
				ledger.created_at,
				receipt_id,
				SUM(CASE WHEN ledger.txtype='CASH' THEN ledger.amount ELSE 0 END) as CASH,
				SUM(CASE WHEN ledger.txtype='CASH' THEN ledger.tax ELSE 0 END) as TAX_CASH,
				SUM(CASE WHEN ledger.txtype='CARD' THEN ledger.amount ELSE 0 END) as CARD,
				SUM(CASE WHEN ledger.txtype='CARD' THEN ledger.tax ELSE 0 END) as TAX_CARD,
				SUM(ledger.amount) as SUBTOTAL,
				SUM(ledger.tax) as TAX_TOTAL,
				SUM(ledger.tax+ledger.amount) AS TOTAL
			FROM ledger
			WHERE ledger.user_id=".$repId."
			group by receipt_id
			ORDER BY created_at DESC
		";
		$transactions = DB::select($sql);
		return View::make('reports.transactions',compact('consultant','transactions'));
	}

	public function TransactionsByBatch($batchId)
	{
		$transactions = [];
		$sql = "
			SELECT
				id,
				transaction,
				amount
			FROM payments
			WHERE batchedIn = ".$batchId."
		";
		$payments = DB::connection('mysql-mwl')->select($sql);
		foreach($payments as $payment)
		{
			//echo"<pre>"; print_r($payment); echo"</pre>";
			if(substr($payment->transaction,0,1) == 'b')
			{
				//echo"<p>This is a batch</p>";
				$upstream = $this->TransactionsByBatch($payment->id);
				if((is_array($upstream))&&(count($upstream)>0))
				{
					foreach($upstream as $transaction)
					{
						$transactions[] = $transaction;
					}
				}
				//echo"<pre>"; print_r($payment); echo"</pre>";
			}
			else // it is a transaction
			{
				$transactions[] = $payment->transaction;
			}
		}
		return $transactions;
	}

	public function ReportPayments($repId = null) {
		if(is_null($repId)) $repId = Auth::user()->id;
		$ledger_entries = [];

		$consultant = User::find($repId);
		$sql = "
			SELECT 
				payments.id,
				ROUND(SUM(payments.amount), 2) as amount,
				CASE 
					WHEN (payments.created_at != '0000-00-00 00:00:00') THEN payments.created_at 
					WHEN ((payments.updated_at != '0000-00-00 00:00:00') AND (payments.created_at = '0000-00-00 00:00:00')) THEN payments.updated_at 
					ELSE '2015-01-01' END as created_at,
				DATE_FORMAT(payments.updated_at,'%m/%d/%Y') as created_at
			FROM payments 
			LEFT JOIN accounts on payments.account = accounts.id
			LEFT JOIN tid on tid.account=accounts.id 
			LEFT JOIN users ON users.id = tid.id
			WHERE users.username = ".$repId." AND batchedIn = -1
			GROUP BY payments.id
			ORDER BY created_at DESC	
		";
/*		$sql = "
			SELECT 
				payments.id,
				ROUND(SUM(payments.amount), 2) as amount,
				CASE 
					WHEN (payments.created_at != '0000-00-00 00:00:00') THEN payments.created_at 
					WHEN ((payments.updated_at != '0000-00-00 00:00:00') AND (payments.created_at = '0000-00-00 00:00:00')) THEN payments.updated_at 
					ELSE '2015-01-01' END as created_at,
				DATE_FORMAT(payments.updated_at,'%m/%d/%Y') as created_at
			FROM users 
			INNER JOIN tid ON (tid.id=users.id) 
			INNER JOIN accounts ON (accounts.id=tid.account) 
			LEFT JOIN payments ON (payments.account=accounts.id) 
			WHERE users.username=".$repId." AND batchedIn = -1 
			GROUP BY payments.id
			ORDER BY created_at DESC
		";
*/		$payments = DB::connection('mysql-mwl')->select($sql);
		//the only way right now to do this correctly, is to loop through each of the transactions and check to see if it is a batch itself
		foreach($payments as $payment)
		{
			$payment_transactions = $this->TransactionsByBatch($payment->id);
			$payment_fees = [];
			$fees = [];
			$sql = "
				SELECT
					ROUND(SUM(amount),2) as amount,
					description
				FROM payments
				WHERE transaction in ('".implode("','",$payment_transactions )."')
				GROUP BY account
			";
			$fees = DB::connection('mysql-mwl')->select($sql);
			foreach($fees as $fee)
			{
				if($fee->description == 'Merchant Payment') continue;
				$fee_description = (in_array($fee->description,['Controlpad Processing Fee','LLR Processing Fee','CMS Gateway Fee']))?"Processing_Fees":str_replace(" ","_",$fee->description);
				if(isset($payment_fees[$fee_description]))
				{
					$payment_fees[$fee_description] += $fee->amount;
				}
				else
				{
					$payment_fees[$fee_description] = $fee->amount;
				}
				//echo"<pre>"; print_r($fee); echo"</pre>";
			}
			$payment->fees = $payment_fees;
			
			//$payment_transactions = [];
			$sql = "
				SELECT
					transaction.*,
					payments.transaction as refNum,
					SUM(payments.amount) as paid,
					CASE WHEN customer IS NULL THEN 'N/A' ELSE customer END as customer,
					CASE 
						WHEN (transaction.created_at != '0000-00-00 00:00:00') THEN transaction.created_at 
						WHEN ((transaction.updated_at != '0000-00-00 00:00:00') AND (transaction.created_at = '0000-00-00 00:00:00')) THEN transaction.updated_at 
						ELSE '1972-08-28' END as created_at,
					CASE cashsale WHEN 1 THEN 'Cash' ELSE 'Credit' END as txtype
				FROM payments
				LEFT JOIN accounts on payments.account = accounts.id
				LEFT JOIN tid on tid.account=accounts.id 
				LEFT JOIN users ON users.id = tid.id
				LEFT JOIN transaction ON transaction.refNum=payments.transaction
				WHERE payments.transaction in ('".implode("','",$payment_transactions )."')
				GROUP BY payments.transaction
			";
			$transactions = DB::connection('mysql-mwl')->select($sql);
			$sql = "
				SELECT
					ledger.transactionid,
					ledger.amount,
					ledger.tax,
					ledger.txtype,
					ledger.created_at,
					ledger.receipt_id
				FROM ledger
				WHERE ledger.transactionid in ('".implode("','",$payment_transactions )."')
				GROUP BY ledger.transactionid
			";
			$ledgers = DB::select($sql);
			foreach($ledgers as $ledger)
			{
				$ledger_entries[$ledger->transactionid] = (array) $ledger;
			}

			$payment->transactions = $transactions;
			//echo"<pre>"; print_r($payment_fes); echo"</pre>";
		}
		// /return $payments;


		/*		
		$startDate = date('Y-m-d',strtotime(date('Y-01-01')));
		$endDate = date('Y-m-d');
		$consultant = User::find($repId);
		$result = App::make('ExternalAuthController')->getReportPayments($consultant->id,$startDate,$endDate);
		if(is_null($result))
		{
			$payments = [];
		}
		else
		{
			$payments = $result->Batches;
		}
		*/		
		return View::make('reports.payments',compact('consultant','payments','ledger_entries'));
	}

	public function ReportPaymentsDetails($payment_id,$userId = null) {
		if(is_null($repId)) $repId = Auth::user()->id;
		$sql = "
			SELECT 
				transaction,
				payments.*,
				ROUND(payments.amount, 2) as amount,
				payments.created_at
			FROM users 
			INNER JOIN tid ON (tid.id=users.id) 
			INNER JOIN accounts ON (accounts.id=tid.account) 
			LEFT JOIN payments ON (payments.account=accounts.id) 
			WHERE users.username=".$userId." AND batchedIn = ".$payment_id."
			ORDER BY payments.created_at
		";
		$payment = DB::connection('mysql-mwl')->select($sql);

/*		if(is_null($repId)) $repId = Auth::user()->id;
		$startDate = date('Y-m-d',strtotime(date('Y-01-01')));
		$endDate = date('Y-m-d');
		$consultant = User::find($repId);
		$result = App::make('ExternalAuthController')->getReportTransactionsByBatch($consultant->id,$startDate,$endDate);
		if(is_null($result))
		{
			$transactions = [];
		}
		else
		{
			$transactions = $result->Transactions;
		}
		//$transactions = $result->Transactions;
*/		
		return View::make('reports.payment-details',compact('transactions','consultant'));
	}

	public function ReportTransactionDetails($transactionId) {
		$sql = "
			SELECT
				refNum as id,
				customer,
				authAmount as amount,
				status,
				CASE cashsale WHEN 1 THEN 'Cash' ELSE 'Credit' END as type,
				CASE processed WHEN 1 THEN 'Processed' ELSE 'Pending' END as collected,
				salesTax,
				LEFT(created_at,10) as transaction_date
			FROM transaction 
			WHERE refNum=".$transactionId." 
		";
		$transaction = DB::connection('mysql-mwl')->select($sql)[0];
		//echo"<pre>"; print_r($transaction); echo"</pre>";
		//exit;
		return View::make('reports.transaction-details',compact('transaction'));
	}


}
