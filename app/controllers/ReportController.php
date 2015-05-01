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

	public function orders($id = '')
	{
		if (Auth::user()->hasRole(['Superadmin','Admin'])) { 
			Session::flash('ledgerUserId',$id);
            $id = Auth::user()->id;
		}
        
		$orderlist = Receipt::getReceipts($id);
        
        $dates = $this->getMondaysEveryWeek(date('Y-m-d'),date('Y-m-d'));
        
        $rdb = Receipt::countReceiptsForDate($id,$dates[0],$dates[1]);
        
        $ytd = $this->getDatesYTD();
        $temp = $ytd;
        $ytd = array();
        foreach($temp as $day){
            $query_month = strtotime('+1 month',strtotime($day));
            $ytd[date('Y-m-d',$query_month)] = date('M Y',strtotime($day));
        }
        $daily = $this->getDailyDatesFromRange("2015-03-24","2015-04-09");

		$queries = DB::getQueryLog();
		$last_query = end($queries);
		\Log::info('LAST QUERY: '.print_r($last_query,true));

		//return Response::json($orderlist);
		return View::make('reports.orders', compact('orderlist','dates','rdb','ytd','daily'));
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
        $user_id = Session::has('ledgerUserId') ? Session::get('ledgerUserId'): 0;
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
		else $id = 0; //Auth::user()->id;

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

}
