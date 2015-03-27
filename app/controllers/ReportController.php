<?php

class ReportController extends \BaseController {

/*
    Route::get('reports', 'ReportController@index');
    Route::get('api/report-sales/{id}', 'ReportController@getReportSales');
    Route::get('api/report-inventory/{id}', 'ReportController@getReportInventory');
*/
	public function index()
	{
		return View::make('reports.index');
	}


	public function getReportSales() {

		$sales = App::make('ExternalAuthController')->getLedger(Auth::user()->id);

		return Response::json(array('data'=>$sales,'count'=>count($sales)),200,[], JSON_PRETTY_PRINT);
	}

	public function getReportInventory($id = '') {
		return Response::json(null,200);
	}

}
