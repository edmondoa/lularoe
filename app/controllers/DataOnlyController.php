<?php 

class DataOnlyController extends \BaseController
{

	/*
	 * Downline
	 */
	 
	// immediate downline
	public function getFirstBranch() {
		return;
	}
	
	public function getAllBranches() {
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$result = Commission::get_org_tree(0);
			$response = Response::make(json_encode($result, JSON_PRETTY_PRINT), 200);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		$result = Commission::get_org_tree(Auth::user()->id);
		$response = Response::make(json_encode($result, JSON_PRETTY_PRINT), 200);
		$response->header('Content-Type', 'application/json');
		return $response;
		//echo"<pre>"; print_r($result); echo"</pre>";
		exit;
	}
	
	/*
	 * Downline
	 */
	 
	// immediate downline
	public function getImmediateDownline($id) {
		if (!Auth::check()) return;
		return User::find($id)->frontline;
	}
	
	// all downline
	public function getAllDownline($id) {
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return User::find(0)->descendants;
		}
		if ($id == 0) {
			return User::find(0)->descendants;
		}
		return User::find($id)->descendants;
	}

	/*
	 * Events
	 */

	// all upcoming events
	public function getAllUpcomingEvents() {
		$events = Uvent::where('date_start', '>', time())->get();
		return $events;
	}
	
	// all past events
	public function getAllPastEvents() {
		$events = Uvent::where('date_start', '<', time())->get();
		return $events;
	}
	
	// all upcoming events by role
	public function getAllUpcomingEventsByRole() {
		if (!Auth::check()) $events = Uvent::where('public', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->role_name == 'Customer') $events = Uvent::where('customers', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->role_name == 'Rep') $events = Uvent::where('reps', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->role_name == 'Editor') $events = Uvent::where('editors', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->role_name == 'Admin') $events = Uvent::where('admins', 1)->where('date_start', '>', time())->get();
		return $events;
	}
	
	// all past events by role
	public function getAllPastEventsByRole() {
		if (!Auth::check()) $events = Uvent::where('public', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->role_name == 'Customer') $events = Uvent::where('customers', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->role_name == 'Rep') $events = Uvent::where('reps', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->role_name == 'Editor') $events = Uvent::where('editors', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->role_name == 'Admin') $events = Uvent::where('admins', 1)->where('date_start', '<', time())->get();
		return $events;
	}

	public function getAllOpportunities(){
		return $opportunities = Opportunity::all();
	}
	
	/*
	 * Leads
	 */

	public function getAllLeads() {
		return Lead::all();
	}
	
	public function getAllLeadsByRep($id) {
		return User::find($id)->leads;
	}

	/*
	 * Users
	 */

	// users
	public function getAllUsers(){
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return User::all();
		}
	}

	// users
	public function getAllConfig(){
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return SiteConfig::all();
		}
	}

}