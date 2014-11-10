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
		$result = Commission::get_org_tree(Auth::user()->id);
		return json_encode($result, JSON_PRETTY_PRINT);
		//echo"<pre>"; print_r($result); echo"</pre>";
		exit;
	}
	
	/*
	 * Downline
	 */
	 
	// immediate downline
	public function getImmediateDownline($id) {
		return User::find($id)->frontline;
	}
	
	// all downline
	public function getAllDownline($id) {
		return User::find($id)->descendants;
	}

	/*
	 * Events
	 */

	// all events
	public function getAllUvents() {
		$events = Uvent::where('date_start', '>', time())->get();
		return $events;
	}
	
	// all events by role
	public function getAllUventsByRole() {
		if (!Auth::user()) $events = Uvent::where('public', 1)->where('date_start', '>', time())->get();
		if (Auth::user()->role_name == 'Customer') $events = Uvent::where('customers', 1)->where('date_start', '>', time())->get();
		if (Auth::user()->role_name == 'Rep') $events = Uvent::where('reps', 1)->where('date_start', '>', time())->get();
		if (Auth::user()->role_name == 'Editor') $events = Uvent::where('editors', 1)->where('date_start', '>', time())->get();
		if (Auth::user()->role_name == 'Admin') $events = Uvent::where('admins', 1)->where('date_start', '>', time())->get();
		return $events;
	}
	 
}