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
			Session::put('ledgerUserId',$id);
		}
		return View::make('reports.index');
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
