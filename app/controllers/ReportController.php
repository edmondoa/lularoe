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
		}
		return View::make('reports.index');
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

		$queries = DB::getQueryLog();
		$last_query = end($queries);
		\Log::info('LAST QUERY: '.print_r($last_query,true));

		//return Response::json($orderlist);
		return View::make('reports.orders', compact('orderlist'));
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
