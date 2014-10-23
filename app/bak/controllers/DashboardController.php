<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		$user = User::findOrFail(Auth::user()->id);
		$sponsor = User::find($user->id)->sponsor;
		$children = User::find($user->id)->children;
		return View::make('dashboard.rep', compact('user', 'sponsor', 'children'));
	}
	
}
