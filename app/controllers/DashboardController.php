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
			$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
			return View::make('dashboard.rep', compact('user', 'sponsor', 'children', 'ranks', 'beta_service_link'));
		}
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$user = User::findOrFail(0);
			$reps = User::all()->count();
			$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
			return View::make('dashboard.admin', compact('user', 'reps', 'beta_service_link'));
		}
	}
	
	public function settings()
	{
		$addresses = User::find(Auth::user()->id)->addresses;
		return View::make('dashboard.settings', compact('addresses'));
	}
	
}