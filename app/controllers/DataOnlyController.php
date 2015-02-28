<?php 

class DataOnlyController extends \BaseController
{

	/************
	 * Cart
	 ************/
	public function getCart() {
		$products = Session::get('products');
		// get product images		
		foreach($products as $product) {
			$attachment = Attachment::where('attachable_type', 'Product')->where('attachable_id', $product->id)->where('featured', 1)->get();
			if (isset($attachment[0])) {
				$media = Media::find($attachment[0]['media_id']);
				$image_sm = explode('.', $media->url);
				if (isset($image_sm[1])) $image_sm = $image_sm[0] . '-sm.' . $image_sm[1];
				else $image_sm = '';
				$product->featured_image = $image_sm;
			}
		}
		return $products;
	}	 	 

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
	
	// all media
	public function getMediaCounts($type) {
		$file_types = [
			0 => ['type' => 'Archive', 'count' => 0],
			1 => ['type' => 'Audio', 'count' => 0],
			2 => ['type' => 'Code', 'count' => 0],
			3 => ['type' => 'Database', 'count' => 0],
			4 => ['type' => 'Document', 'count' => 0],
			5 => ['type' => 'File', 'count' => 0],
			6 => ['type' => 'Image', 'count' => 0],
			7 => ['type' => 'Image file', 'count' => 0],
			8 => ['type' => 'Presentation', 'count' => 0],
			9 => ['type' => 'Spreadsheet', 'count' => 0],
			10 => ['type' => 'Text', 'count' => 0],
			11 => ['type' => 'Video', 'count' => 0],
		];
		
		// count reps media
		if ($type == 'reps') {
			if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
				$medias = Media::all();
				foreach($medias as $key => $media) {
					if (!User::find($media->user_id)->hasRole(['Rep'])) {
						unset($medias[$key]);
					}
				}
			}
		}
		
		// count a specific user's media
		elseif (is_numeric($type)) {
			$id = $type;
			if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || Auth::user()->hasRole(['Rep']) && Auth::user()->id == $id) {
				$medias = Media::where('user_id', $id)->get();
			}
		}
		
		// count all media
		elseif ($type == 'all') {
			if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
				$medias = Media::all();
			}
			elseif (Auth::user()->hasRole(['Rep'])) {
				$medias = Media::where('reps', 1)->get();
			}
		}
		
		// count all media
		elseif ($type == 'shared-with-reps') {
			if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
				$medias = Media::where('reps', 1)->get();
			}
		}
		
		foreach ($medias as $media) {
			foreach($file_types as $key => $file_type) {
				if ($media->type == $file_type['type']) {
					$file_types[$key]['count'] += 1;
				}
			}
		}
		return $file_types;
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
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || Auth::user()->hasRole(['Rep']) && Auth::user()->id == $id) {
			return Media::where('user_id', $id)->get();
		}
	}
	
	// all media by reps
	public function getMediaByReps() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$medias = Media::all();
			$media_with_reps = [];
			foreach($medias as $media) {
				if (User::find($media->user_id)->hasRole(['Rep'])) {
					$media_with_reps[] = $media;
				}
			}
			// foreach($medias as $key => $media) {
				// if (!User::find($media->user_id)->hasRole(['Rep'])) {
					// unset($medias[$key]);
				// }
			// }
			return $media_with_reps;
		}
	}
	
	// all media share with reps
	public function getMediaSharedWithReps() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return Media::where('reps', 1)->get();
		}
	}
	
	// all images by user
	public function getImagesSharedWithReps() {
		return Media::where('reps', 1)->where('type', 'Image')->get();
	}
	
	// all images by user
	public function getImagesByUser($id) {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || Auth::user()->id == $id) {
			return Media::where('user_id', $id)->where('type', 'Image')->get();
		}
	}

	/*
	 * Config
	 */
	
	public function getAllConfig(){
		return SiteConfig::all();
	}	 

	/*
	 * Downline
	 */
	 
	// immediate downline
	public function getNewDownline($id) {
		return User::find($id)->new_descendants()->get();
	}
	 
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
	
	/**********
	 * Downline
	 **********/
	 
	// immediate downline
	public function getImmediateDownline($id) {
		if (!Auth::check()) return;
		return User::find($id)->frontline;
	}
	
	// all downline
	public function getAllDownline($id) {
		DB::connection()->disableQueryLog();
		set_time_limit (120);
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return User::find(0)->descendants;
		}
		if ($id == 0) {
			return User::find(0)->descendants;
		}
		return User::find($id)->descendants;
	}

	/********
	 * Events
	 ********/

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
		if (!Auth::check()) return Uvent::where('public', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->hasRole(['Customer'])) return Uvent::where('customers', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->hasRole(['Rep'])) return Uvent::where('reps', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) return Uvent::where('date_start', '>', time())->get();
	}
	
	// upcoming public events
	public function getUpcomingPublicEvents() {
		return Uvent::where('public', 1)->where('date_start', '>', time())->get();
	}
	
	// all past events by role
	public function getAllPastEventsByRole() {
		if (!Auth::check()) return Uvent::where('public', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->hasRole(['Customer'])) return Uvent::where('customers', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->hasRole(['Rep'])) return Uvent::where('reps', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) return Uvent::where('date_start', '<', time())->get();
	}

	/*********
	 * Parties
	 *********/

	// all upcoming parties
	public function getAllUpcomingParties() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$parties = Party::where('date_start', '>', time())->get();
		}
		elseif (Auth::user()->hasRole(['Rep'])) {
			$parties = Party::where('date_start', '>', time())->where('organizer_id', Auth::user()->id)->where('disabled', 0)->get();
		}
		return $parties;
	}
	
	// all past parties
	public function getAllPastParties() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$parties = Party::where('date_start', '<', time())->get();
		}
		elseif (Auth::user()->hasRole(['Rep'])) {
			$parties = Party::where('date_start', '<', time())->where('organizer_id', Auth::user()->id)->where('disabled', 0)->get();
		}
		return $parties;
	}
	
	// all upcoming parties by role
	public function getAllUpcomingPartiesByRole() {
		if (!Auth::check()) return Party::where('public', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->hasRole(['Customer'])) return Party::where('customers', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->hasRole(['Rep'])) return Party::where('reps', 1)->where('date_start', '>', time())->get();
		elseif (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) return Party::where('date_start', '>', time())->get();
	}
	
	// upcoming public parties
	public function getUpcomingPublicParties() {
		return Party::where('public', 1)->where('date_start', '>', time())->get();
	}
	
	// all past parties by role
	public function getAllPastPartiesByRole() {
		if (!Auth::check()) return Party::where('public', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->hasRole(['Customer'])) return Party::where('customers', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->hasRole(['Rep'])) return Party::where('reps', 1)->where('date_start', '<', time())->get();
		elseif (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) return Party::where('date_start', '<', time())->get();
	}

	// get single party
	public function getParty($id) {
		$party = Party::find($id);
		$party->address = Party::find($id)->address;
		return $party;
	}
	
	
	
	// opportunities
	public function getAllOpportunities(){
		return $opportunities = Opportunity::all();
	}
	
	// items
	public function getAllItems() {
		return Item::all();
	}
	
	// leads
	public function getAllLeads() {
		return Lead::all();
	}
	public function getAllLeadsByRep($id) {
		return User::find($id)->leads;
	}
	
	// pages
	public function getAllPages(){
		return Page::all();
	}
	
	// posts
	public function getAllPosts(){
		if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return Post::all();
		}
		elseif (Auth::user() && Auth::user()->hasRole(['Rep'])) {
			return Post::where('Reps', 1)->where('publish_date', '<', date('Y-m-d h:i:s'))->orWhere('created_at', '<', date('Y-m-d h:i:s'))->orderBy('publish_date')->orderBy('created_at')->get();
		}
		elseif (Auth::user() && Auth::user()->hasRole(['Customer'])) {
			return Post::where('Customers', 1)->where('publish_date', '<', date('Y-m-d h:i:s'))->orWhere('created_at', '<', date('Y-m-d h:i:s'))->orderBy('publish_date')->orderBy('created_at')->get();
		}
		else {
			return Post::where('Public', 1)->where('publish_date', '<', date('Y-m-d h:i:s'))->orWhere('created_at', '<', date('Y-m-d h:i:s'))->orderBy('publish_date')->orderBy('created_at')->get();
		}
	}
	
	// public posts
	public function getPublicPosts() {
		return Post::where('Public', 1)->where('publish_date', '<', date('Y-m-d h:i:s'))->orWhere('created_at', '<', date('Y-m-d h:i:s'))->orderBy('publish_date')->orderBy('created_at')->get();
	}
	
	/**********
	 * Products
	 **********/
	public function getAllProducts() {
		
		// get products
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) $products = Product::with('tags')->get();
		elseif (Auth::user()->hasRole(['Rep'])) $products = Product::where('user_id', Auth::user()->id)->where('disabled', 0)->with('tags')->get();
			
		// get product images		
		foreach($products as $product) {
			$attachment = Attachment::where('attachable_type', 'Product')->where('attachable_id', $product->id)->where('featured', 1)->get();
			if (isset($attachment[0])) {
				$media = Media::find($attachment[0]['media_id']);
				$image_sm = explode('.', $media->url);
				if (isset($image_sm[1])) $image_sm = $image_sm[0] . '-sm.' . $image_sm[1];
				else $image_sm = '';
				$product->featured_image = $image_sm;
			}
		}

		return $products;

	}

	// productCateogires
	public function getAllProductCategories() {
		return ProductCategory::with('tags')->get();
	}

	// productTags
	public function getAllProductTags(){
		return ProductTag::all();
	}

	/**********
	 * Users
	 **********/
	public function getAllUsers(){
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return User::all();
		}
	}

}