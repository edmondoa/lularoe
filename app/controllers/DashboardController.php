<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		// rep dashboard
		if (Auth::user()->hasRole(['Editor', 'Rep'])) {
			$user = User::findOrFail(Auth::user()->id);
			$sponsor = User::find($user->id)->sponsor;
			$children = User::find($user->id)->children;
			$ranks = User::find($user->id)->ranks;
			$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
			$new_downline = User::find($user->id)->new_descendants()->take(10);
			$new_downline_count = User::find($user->id)->new_descendants()->count();
			return View::make('dashboard.rep', compact('user', 'sponsor', 'children', 'ranks', 'beta_service_link', 'new_downline', 'new_downline_count'));
		}
		
		// admin dashboard
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$user = User::findOrFail(Auth::user()->id);
			$reps = User::all()->count();
			$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
			$new_downline = User::find(Auth::user()->id)->new_descendants()->get()->take(10);
			$new_downline_count = User::find($user->id)->new_descendants()->count();
			return View::make('dashboard.admin', compact('user', 'reps', 'beta_service_link', 'new_downline', 'new_downline_count'));
		}
	}
	
	public function settings()
	{
		$addresses = User::find(Auth::user()->id)->addresses;
		return View::make('dashboard.settings', compact('addresses'));
	}
	
}