<?php 

class DataOnlyController extends \BaseController
{


	/**
	 * Media
	 */
	 
	// all media
	public function getAllMedia() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])){ 
            return [
                'count' => Media::count(),
                'data' => Media::all()
            ];
        }
		if (Auth::user()->hasRole(['Rep'])) {
            $raw = Media::where('reps', 1);
			return [
                'count'=>$raw->count(),
                'data'=>$raw->get()
            ];
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
            $raw = Media::where('user_id', $id);
			return [
                'count'=>$raw->count(),
                'data'=>$raw->get()
            ];
		}
	}
	
	// all media by reps
	public function getMediaByReps() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
            $count = Media::count();
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
			return [
                'count'=>$count,
                'data'=>$media_with_reps
            ];
		}
	}
	
	// all media by reps
	public function getMediaSharedWithReps() {
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
            $raw = Media::where('reps', 1);
			return [
                'count'=>$raw->count(),
                'data'=>$raw->get()
            ];
		}
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
 	public function getAllDownline($id = 0) {
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

	/*
	 * Events
	 */

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
		return $events;
	}
	
	// upcoming public events
	public function getUpcomingPublicEvents() {
		return Uvent::where('public', 1)->where('date_start', '>', time())->get();
	}
	
	// all past events by role
	public function getAllPastEventsByRole() {
		return $events;
	}

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
	
	// leads
	public function getAllLeads() {
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
            'count' =>Lead::count(),
            'data' => Lead::orderBy("updated_at", "DESC")
                            ->orderBy($order, $sequence)
                            ->skip($offset)
                            ->limit($limit)
                            ->get()
        ];
	}
	public function getAllLeadsByRep($id) {
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
            'count' => User::find($id)->leads()->count(),
            'data' =>  User::find($id)
                            ->leads()
                            ->orderBy("updated_at", "DESC")
                            ->orderBy($order, $sequence)
                            ->skip($offset)
                            ->limit($limit)
                            ->get()
        ];
	}
	
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
	public function getPublicPosts(){
		return Post::where('Public', 1)
                    ->where('publish_date', '<', date('Y-m-d h:i:s'))
                    ->orWhere('created_at', '<', date('Y-m-d h:i:s'))
                    ->orderBy('publish_date')
                    ->orderBy('created_at')
                    ->get();
	}
	
	// products
	public function getAllProducts(){
        $p = Input::get('p');
        $l = Input::get('l');
        $o = Input::get('o');
        $s = Input::get('s');
        $page = $p ? $p : 1;
        $limit = $l ? $l : 10;
        $order = $o ? $o : "name";
        $sequence = $s == "true" || !$s ? "ASC" : "DESC";
        $offset = ($page - 1) * $limit;
        return [
            'count' => Product::with('tags')
                        ->count(),
            'data' => Product::with('tags')
                        ->orderBy("name", "DESC")
                        ->orderBy($order, $sequence)
                        ->skip($offset)
                        ->limit($limit)
                        ->get()
        ];
	}

	// productCateogires
	public function getAllProductCategories(){
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

	// users
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
            $data = User::orderBy("updated_at", "DESC")
                        ->orderBy($order, $sequence)
                        ->orderBy("last_name", "DESC")
                        ->orderBy("first_name", "DESC")
                        ->skip($offset)
                        ->take($limit)
                        ->get();
			return [
                        'count'=>User::count(),
                        'data' =>$data
                   ];
		}
	}
    
    //search users
    public function getSearchUsers($keyword){
         $limit = 10;
         $count = User::where('first_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('last_name','LIKE','%'.$keyword.'%')
                    ->orWhere('id',$keyword)
                    ->count();
         $data = User::where('first_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('last_name','LIKE','%'.$keyword.'%')
                    ->orWhere('id',$keyword)
                    ->take($limit)
                    ->get()
                    ->map(function($user) use (&$temp){
             $name = $user->id.' - '.$user->full_name;
             return ["id"=>$user->id,"name"=>$name];
         });
                    
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
