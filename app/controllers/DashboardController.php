<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		$user = User::findOrFail(Auth::user()->id);
		$sponsor = User::find($user->id)->sponsor;
		$children = User::find($user->id)->children;
		$ranks = User::find($user->id)->ranks;
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor', 'Rep'])) {
			return View::make('dashboard.rep', compact('user', 'sponsor', 'children', 'ranks'));
		}
		// if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			// return View::make('dashboard.admin', compact('user', 'sponsor', 'children', 'ranks'));
		// }
	}
	
	public function settings()
	{
		$addresses = User::find(Auth::user()->id)->addresses;
		return View::make('dashboard.settings', compact('addresses'));
	}
	
}