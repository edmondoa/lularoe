<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		$user = User::findOrFail(Auth::user()->id);
		$sponsor = User::find($user->id)->sponsor;
		$children = User::find($user->id)->children;
		$ranks = User::find($user->id)->ranks;
		return View::make('dashboard.rep.index', compact('user', 'sponsor', 'children', 'ranks'));
	}
	
}
