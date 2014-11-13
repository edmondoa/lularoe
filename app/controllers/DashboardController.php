<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		if (Auth::user()->hasRole(['Editor', 'Rep'])) {
			$user = User::findOrFail(Auth::user()->id);
			$sponsor = User::find($user->id)->sponsor;
			$children = User::find($user->id)->children;
			$ranks = User::find($user->id)->ranks;
			return View::make('dashboard.rep', compact('user', 'sponsor', 'children', 'ranks'));
		}
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$user = User::findOrFail(0);
			$reps = User::all()->count();
			return View::make('dashboard.admin', compact('user', 'reps'));
		}
	}
	
	public function settings()
	{
		$addresses = User::find(Auth::user()->id)->addresses;
		return View::make('dashboard.settings', compact('addresses'));
	}
	
}