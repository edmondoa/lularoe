<?php 

class DataOnlyController extends \BaseController
{
	/*##############################################################################################
	Report datapoints
	##############################################################################################*/
	public function getPaymentsByUser($userId)
	{
		$sql = "
			SELECT
				accounts.id,
				transaction,
				payments.id as payment_id,
				(CASE WHEN paid=1 THEN SUM(amount) ELSE null END) as 'paidout',
				(CASE WHEN paid=0 THEN SUM(amount) ELSE null END) as unpaid,
				cashtransaction,
				payments.consignment,
				batchedIn,
				LEFT(payments.created_at,10) as payment_date
			FROM users 
			INNER JOIN tid ON (tid.id=users.id) 
			INNER JOIN accounts ON (accounts.id=tid.account) 
			LEFT JOIN payments ON (payments.account=accounts.id) 
			WHERE users.username=".$userId." 
			GROUP BY batchedIn
			ORDER BY payment_date
		";
		//echo"<pre>"; print_r($sql); echo"</pre>";
		//exit;
		$payments = DB::connection('mysql-mwl')->select($sql);
		return $payments;
	}

	public function getTransactionsByPayment()
	{
		$sql = "
			SELECT
				accounts.id,
				transaction,
				payments.id as payment_id,
				(CASE WHEN paid=1 THEN SUM(amount) ELSE null END) as 'paidout',
				(CASE WHEN paid=0 THEN SUM(amount) ELSE null END) as unpaid,
				cashtransaction,
				payments.consignment,
				batchedIn,
				LEFT(payments.created_at,10) as payment_date
			FROM users 
			INNER JOIN tid ON (tid.id=users.id) 
			INNER JOIN accounts ON (accounts.id=tid.account) 
			LEFT JOIN payments ON (payments.account=accounts.id) 
			WHERE users.username=".$userId." 
			GROUP BY payment_date
			ORDER BY payment_date
		";
		//echo"<pre>"; print_r($sql); echo"</pre>";
		//exit;
		$payments = DB::connection('mysql-mwl')->select($sql);
		return $payments;

	}

	public function getTransactionDetails($refNum)
	{
		$sql = "
			SELECT
				*
			FROM transaction 
			WHERE refNum=".$refNum." 
		";
		//echo"<pre>"; print_r($sql); echo"</pre>";
		//exit;
		$payments = DB::connection('mysql-mwl')->select($sql);
		return $payments;

	}

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

	/**********
	 * Media
	 **********/

	// get media counts
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
			$medias = Media::where('reps', 1)->get();
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
			return Media::where('reps', 1)->where('type','Image')->with('tags')->get();
		}
	}
	
	// all media by user
	public function getMediaByUser($id) {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return Media::where('user_id', $id)->with('tags')->get();
		}
		elseif (Auth::user()->id == $id) {
			return Media::where('user_id', $id)->where('disabled', 0)->with('tags')->get();
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
			return Media::where('reps', 1)->with('tags')->get();
		}
		elseif (Auth::user()->hasRole(['Rep'])) {
			return Media::where('reps', 1)->where('disabled', 0)->with('tags')->get();
		}
	}
	
	// all images by user
	public function getImagesSharedWithReps() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return Media::where('reps', 1)->where('type', 'Image')->with('tags')->get();
		}
		elseif (Auth::user()->hasRole(['Rep'])) {
			return Media::where('reps', 1)->where('type', 'Image')->where('disabled', 0)->with('tags')->get();
		}
	}
	
	// all images by user
	public function getImagesByUser($id) {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return Media::where('user_id', $id)->where('type', 'Image')->with('tags')->get();
		}
		elseif (Auth::user()->id == $id) {
			return Media::where('user_id', $id)->where('type', 'Image')->where('disabled', 0)->with('tags')->get();
		}

	}

	// media tags
	public function getMediaTags() {
		$tags = Tag::where('taggable_type', 'Media')->select('name')->groupBy('name')->get();
		foreach($tags as $tag) {
			$tag->count = 0;
		}
		return $tags;
	}

	/*
	 * Config
	 */
	
	public function getAllConfig(){
		return [
			'count'=>SiteConfig::count(),
			'data'=>SiteConfig::all()
		];
	}	 

	/*
	 * Downline
	 */
	 
	// immediate downline
	public function getNewDownline($id) {
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "last_name";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		return [
			'count' => User::find($id)
						->new_descendants()
						->count(),
			'data' =>User::find($id)
						->new_descendants()
						->orderBy("updated_at", "DESC")
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get()
		];
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
		$data = [];
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "last_name";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		$count = User::find($id)
					->frontline()
					->count();
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$data = User::find($id)
						->frontline()
						->orderBy("updated_at", "DESC")
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		elseif(Auth::user()->hasRole(['Rep']) && (Auth::user()->hasRepInDownline($id)) || Auth::user()->id == $id) {
			$data = User::find($id)
						->frontline()
						->orderBy("updated_at", "DESC")
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		
		return [
					'count'=>$count,
					'data' =>$data
			   ];
	}
	
	// all downline
	public function getAllDownline($id) {
		DB::connection()->disableQueryLog();
		set_time_limit (120);
		
		$data = [];
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "last_name";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		$count = User::find($id)
					->descendants()
					->count();
		
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$data = User::find($id)
						->descendants()
						->orderBy("updated_at", "DESC")
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		elseif(Auth::user()->hasRole(['Rep']) && (Auth::user()->hasRepInDownline($id)) || Auth::user()->id == $id) {
			$data = User::find($id)
						->descendants()
						->orderBy("updated_at", "DESC")
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		return [
			'count' => $count,
			'data' => $data 
		];
	}

	/********
	 * Events
	 ********/

	public function getAllUvents(){
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "date_start";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		return [
			'count'=>Uvent::count(),
			'data' =>Uvent::orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get() 
		];
	}

	// all upcoming events
	public function getAllUpcomingEvents() {
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "date_start";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		return [
			'count' => Uvent::where('date_start', '>', time())
							->count(),
			'data' => Uvent::where('date_start', '>', time())
							->orderBy($order, $sequence)
							->skip($offset)
							->limit($limit)
							->get()
		];
	}
	
	// all past events
	public function getAllPastEvents() {
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "date_start";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		return [
			'count' => Uvent::where('date_start', '<', time())
							->count(),
			'data' => Uvent::where('date_start', '<', time())
							->orderBy($order, $sequence)
							->skip($offset)
							->limit($limit)
							->get()
		];
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
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "title";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		return [
			'count' =>Opportunity::count(),
			'data' => Opportunity::orderBy("title", "DESC")
								->orderBy($order, $sequence)
								->skip($offset)
								->limit($limit)
								->get()
		];
	}
	
	// items
	public function getAllItems() {
		return Item::all();
	}
	
	/**********
	 * Leads
	 * ********/
	public function getAllLeads() {
		return Lead::all();
	}
	public function getAllLeadsByRep($id) {
		return User::find($id)->leads;
	}
	// public function getAllLeads() {
		// $p = Input::get('p');
		// $l = Input::get('l');
		// $o = Input::get('o');
		// $s = Input::get('s');
		// $page = $p ? $p : 1;
		// $limit = $l ? $l : 10;
		// $order = $o ? $o : "last_name";
		// $sequence = $s == "true" || !$s ? "ASC" : "DESC";
		// $offset = ($page - 1) * $limit;
		// return [
			// 'count' =>Lead::count(),
			// 'data' => Lead::orderBy("updated_at", "DESC")
							// ->orderBy($order, $sequence)
							// ->skip($offset)
							// ->limit($limit)
							// ->get()
		// ];
	// }
	// public function getAllLeadsByRep($id) {
		// $p = Input::get('p');
		// $l = Input::get('l');
		// $o = Input::get('o');
		// $s = Input::get('s');
		// $page = $p ? $p : 1;
		// $limit = $l ? $l : 10;
		// $order = $o ? $o : "last_name";
		// $sequence = $s == "true" || !$s ? "ASC" : "DESC";
		// $offset = ($page - 1) * $limit;
		// return [
			// 'count' => User::find($id)->leads()->count(),
			// 'data' =>  User::find($id)
							// ->leads()
							// ->orderBy("updated_at", "DESC")
							// ->orderBy($order, $sequence)
							// ->skip($offset)
							// ->limit($limit)
							// ->get()
		// ];
	// }
	
	// pages
	public function getAllPages(){
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "title";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		return [
			'count' => Page::count(),
			'data' =>  Page::orderBy("title", "DESC")
							->orderBy($order, $sequence)
							->skip($offset)
							->limit($limit)
							->get()
		];
	}
	
	// posts
	public function getAllPosts(){
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "created_at";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		$offset = ($page - 1) * $limit;
		
		if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$count = Post::count();
			$data = Post::orderBy("created_at", "DESC")
					->orderBy($order, $sequence)
					->skip($offset)
					->limit($limit)
					->get();
		}
		elseif (Auth::user() && Auth::user()->hasRole(['Rep'])) {
			$count = Post::where('Reps', 1)
						->where('publish_date', '<', date('Y-m-d h:i:s'))
						->orWhere('created_at', '<', date('Y-m-d h:i:s'))
						->count();
			$data = Post::where('Reps', 1)
						->where('publish_date', '<', date('Y-m-d h:i:s'))
						->orWhere('created_at', '<', date('Y-m-d h:i:s'))
						->orderBy('publish_date')
						->orderBy('created_at')
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		elseif (Auth::user() && Auth::user()->hasRole(['Customer'])) {
			$count = Post::where('Customers', 1)
						->where('publish_date', '<', date('Y-m-d h:i:s'))
						->orWhere('created_at', '<', date('Y-m-d h:i:s'))
						->count();
			$data = Post::where('Customers', 1)
						->where('publish_date', '<', date('Y-m-d h:i:s'))
						->orWhere('created_at', '<', date('Y-m-d h:i:s'))
						->orderBy('publish_date')
						->orderBy('created_at')
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		else {
			$count = Post::where('Public', 1)
						->where('publish_date', '<', date('Y-m-d h:i:s'))
						->orWhere('created_at', '<', date('Y-m-d h:i:s'))
						->count(); 
			$data = Post::where('Public', 1)
						->where('publish_date', '<', date('Y-m-d h:i:s'))
						->orWhere('created_at', '<', date('Y-m-d h:i:s'))
						->orderBy('publish_date')
						->orderBy('created_at')
						->orderBy($order, $sequence)
						->skip($offset)
						->limit($limit)
						->get();
		}
		
		return [
			'count' => $count,
			'data' =>  $data
		]; 
	}
	
	// public posts
	public function getPublicPosts() {
		return Post::where('Public', 1)
					->where('publish_date', '<', date('Y-m-d h:i:s'))
					->orWhere('created_at', '<', date('Y-m-d h:i:s'))
					->orderBy('publish_date')
					->orderBy('created_at')
					->get();
	}
	
	/**********
	 * Products
	 **********/
	public function getAllProducts() {
		
		// get products
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) $products = Product::with('tags')->get();
		elseif (Auth::user()->hasRole(['Rep'])) $products = Product::where('user_id', Auth::user()->id)->where('disabled', 0)->with('tags')->get();
			
		// get product images		
		foreach($products as $idx=>$product) {
			$attachment = Attachment::where('attachable_type', 'Product')->where('attachable_id', $product->id)->where('featured', 1)->get();
			if (isset($attachment[0])) {
				$media = Media::find($attachment[0]['media_id']);
				$image_sm = explode('.', $media->url);
				if (isset($image_sm[1])) $image_sm = $image_sm[0] . '-sm.' . $image_sm[1];
				else $image_sm = '';
				$products[$idx]->featured_image = $image_sm;
				// $product->featured_image = $image_sm;
			}
		}

		return ['count'=>$products
						->count(),'data'=>$products];

	}

	// productCateogires
	public function getAllProductCategories() {
		$raw = ProductCategory::with('tags');
		return [
			'count' => $raw->count(),
			'data' => $raw->get()
		];
	}

	// productTags
	public function getAllProductTags(){
		return ProductTag::all();
	}

	/**********
	 * Users
	 **********/
	public function sanitizeAllUsers(){
		$p = Input::get('p');
		$page = $p ? $p : 1;
		$limit = 10;
		$order = "last_name";
		$sequence = "ASC";
		$offset = ($page - 1) * $limit;
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$data = User::orderBy($order, $sequence)
						->skip($offset)
						->take($limit)
						->get(); 
						
			foreach($data as $u)
			{
				$user = User::find($u->id);
				$user->first_name = ucwords(trim($u->first_name));
				$u->first_name = $user->first_name; 
				$user->last_name = ucwords(trim($u->last_name));
				$u->last_name = $user->last_name;
				$user->save();
			};
			
			return [
						'count'=>User::count(),
						'data' =>$data,
						'message' => 'Sanitation done on page '.$page
				   ];   
				
		}
	 }
	 
	public function getAllUsers(){
		$p = Input::get('p');
		$l = Input::get('l');
		$o = Input::get('o');
		$s = Input::get('s');
		$page = $p ? $p : 1;
		$limit = $l ? $l : 10;
		$order = $o ? $o : "last_name";
		$sequence = $s == "true" || !$s ? "ASC" : "DESC";
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$offset = ($page - 1) * $limit;
			
			/*
			if(isset($keyword) && $keyword != ""){
				$data = UserList::where('first_name', 'LIKE', '%'.$keyword.'%')
						->orWhere('last_name','LIKE','%'.$keyword.'%')
						->orderBy($order, $sequence);
			}else{
				$data = UserList::orderBy($order, $sequence);
			}
			
			
			$data = $data->skip($offset)
						->take($limit)
						->get();
			*/
			
			$results = DB::select( DB::raw("SELECT * FROM users") );

			$queries = DB::getQueryLog();
			$last_query = end($queries);
			\Log::info('USERLIST::ALL QUERY: '.print_r($last_query,true));

			return [ 'count'=>count($results),'data'=>$results,'message'=>'UserList' ];


/* ELOQUNT TOO SLOW
			$data = UserList::all();            


			return [
						'count'=>UserList::count(),
						'data' =>$data,
						'message' => 'UserList'
				   ];
*/
		}
	}

	//search users
	public function getSearchUsers($keyword){
		 $type = Input::get('type');
		 
		 $limit = 10;
		 $raw = User::where('first_name', 'LIKE', '%'.$keyword.'%')
					->orWhere('last_name','LIKE','%'.$keyword.'%');
/*
					->orderBy("last_name", "ASC")
					->orderBy("first_name", "ASC");
*/
		 $count = $raw->count();
		 $data = $raw->take($limit)
					->get();
		 if($type != 'all'){
			 $data = $data->map(function($user) use (&$temp){
				 $name = $user->id.' - '.$user->full_name;
				 return ["id"=>$user->id,"name"=>$name];
			 });
		 }
					
		 return [
			'count' => $count,
			'data' => $data
		 ];
	}
	
	public function getAllUserSites(){
		$count = UserSite::count();
		$data = UserSite::all();
		
		return [
			'count' => $count,
			'data' => $data
		];
	}

}
