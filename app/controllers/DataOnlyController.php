<?php 

class DataOnlyController extends \BaseController
{


	/**
	 * Media
	 */
	 
	// all media
	public function getAllMedia() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) return Media::all();
		if (Auth::user()->hasRole(['Rep'])) {
			return Media::where('reps', 1)->get();
		}
	}
	
	// all images
	public function getAllImages() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) return Media::where('type', 'Image')->get();
		if (Auth::user()->hasRole(['Rep'])) {
			return Media::where('reps', 1)->where('type','Image')->get();
		}
	}
	
	// all media by user
	public function getMediaByUser($id) {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || Auth::user()->id == $id) {
			return Media::where('user_id', $id)->where('type', 'Image')->get();
		}
	}
	
	// all images by user
	public function getImagesByUser($id) {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || Auth::user()->id == $id) {
			return Media::where('user_id', $id)->where('type', 'Image')->get();
		}
	}

	/*
	 * Downline
	 */
	 
	// immediate downline
	public function getFirstBranch() {
		return;
	}
	
	public function getAllBranches() {
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$result = Commission::get_org_tree(Auth::user()->id);
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
			return User::find(Auth::user()->id)->descendants;
		}
		/*
		if ($id == 0) {
			return User::find(0)->descendants;
		}
		*/
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
	
	// leads
	public function getAllLeads() {
		return Lead::all();
	}
	
	public function getAllLeadsByRep($id) {
		return User::find($id)->leads;
	}
	
	// products
	public function getAllProducts(){
		return Product::with('tags')->get();
	}

	// productCateogires
	public function getAllProductCategories(){
		return ProductCategory::all();
	}

	// users
	public function getAllUsers($page=1,$limit=10){
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
            $offset = ($page - 1) * $limit;
            error_log(print_r(compact("offset","page","limit"),true));
			return [
                        "count"=>User::count(),
                        "data" =>User::skip($offset)->take($limit)->get()
                   ];
		}
	}

}
