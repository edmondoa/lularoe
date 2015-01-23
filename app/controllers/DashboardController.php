<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		try { 
			$user = Auth::user(); // this should accomodate finding the user only once .. right?

			if (Auth::user()->hasRole(['Editor', 'Rep'])) {

				// Why are we getting the user twice here?
				//$user = User::findOrFail(Auth::user()->id);
				
				$sponsor = User::find($user->id)->sponsor;
				$children = User::find($user->id)->children;
				$ranks = User::find($user->id)->ranks;
				$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
				return View::make('dashboard.rep', compact('user', 'sponsor', 'children', 'ranks', 'beta_service_link'));
			}
			elseif (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
				// We are assuming the admin/superadmin is always uid 0 .. 
				// for LLR this is not the case from our data import				
				//$user = User::findOrFail(0);
				$reps = User::all()->count();
				$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
				return View::make('dashboard.admin', compact('user', 'reps', 'beta_service_link'));
			}
			else {
				return false; // Or return some 404 or back to login page
			}
		}
		catch (Exception $e) {
			return null;
		}
	}
	
	public function settings()
	{
		$addresses = User::find(Auth::user()->id)->addresses;
		return View::make('dashboard.settings', compact('addresses'));
	}
	
}
