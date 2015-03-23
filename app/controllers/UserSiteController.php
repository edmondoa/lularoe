<?php

class UserSiteController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllUserSites(){
		$userSites = UserSite::all();
		foreach ($userSites as $userSite)
		{
			if (strtotime($userSite['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$userSite['new'] = 1;
			}
		}
		return $userSites;
	}

	/**
	 * Display a listing of userSites
	 *
	 * @return Response
	 */
	public function index()
	{
		$userSites = UserSite::all();

		return View::make('userSite.index', compact('userSites'));
	}

	/**
	 * Show the form for creating a new userSite
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('userSite.create');
	}

	/**
	 * Store a newly created userSite in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), UserSite::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// format checkbox values for database
		$data['display_phone'] = isset($data['display_phone']) ? 1 : 0;

		UserSite::create($data);

		return Redirect::route('userSite.index')->with('message', 'Site created.');
	}

	public function show($public_id)
	{
		$user = User::where('public_id', $public_id)->first();
		if ($user->image == '') $user->image = '/img/users/default-avatar.png';
		else $user->image = '/img/users/avatars/' . $user->image;
		
		$userSite = UserSite::where('user_id', $user->id)->first();
		if ($userSite->banner == '') $userSite->banner = '/img/users/default-banner.jpg';
		else $userSite->banner = '/img/users/banners/' . $userSite->banner;

		$opportunities = Opportunity::where('public', 1)->where('deadline', '>', time())->orWhere('deadline', '')->take(10)->orderBy('updated_at', DESC)->get();

	}

	/**
	 * Show the form for editing the specified userSite.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->id == $id || Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			$userSite = UserSite::firstOrNew(['user_id'=> $id]);
			$userSite->save();
			
			// get user privacy preferences
			$user = User::find($id);
			$checked = [];
			// format checkbox values for database
			$checked['hide_email'] = $user->hide_email == 1 ? 0 : 1;
			$checked['hide_phone'] = $user->hide_phone == 1 ? 0 : 1;
			$checked['hide_billing_address'] = $user->hide_billing_address == 1 ? 0 : 1;
			$checked['hide_shipping_address'] = $user->hide_shipping_address == 1 ? 0 : 1;
			
			return View::make('userSite.edit', compact('userSite', 'checked'));
		}
	}

	/**
	 * Update the specified userSite in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$userSite = UserSite::findOrFail($id);
		$user = User::where('id', $userSite->user_id)->first();
		$validator = Validator::make($data = Input::all(), UserSite::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// user avatar
        if (Input::file('image')) {
            $filename = '';
            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $destinationPath = public_path() . '/img/users/avatars/';
                $extension = $file->getClientOriginalExtension();
                
				// generate file name and check for existing
				$filename = str_random(20) . '.' . $extension;
				$existing_file = User::where('image', $filename)->get();
				while (count($existing_file) > 0) {
					$filename = str_random(20) . '.' . $extension;
				}
                
                $uploadSuccess   = $file->move($destinationPath, $filename);
    
                // open an image file
                $img = Image::make('img/users/avatars/' . $filename);
    
                // now you are able to resize the instance
                $img->fit(500, 500);
    
                // finally we save the image as a new image
                $img->save('img/users/avatars/' . $filename);
    
                $data['image'] = $filename;
				
				// delete old image if exists
				$old = $user->image;
				$user->image = $filename;
				$user->save();
				if (is_file('img/users/avatars/' . $old)) {
					unlink('img/users/avatars/' . $old);
				}
            }
        }
		
		// banner
        if (Input::file('banner')) {
            // upload and link to image
            $filename = '';
            if (Input::hasFile('banner')) {
                $file = Input::file('banner');
                $destinationPath = public_path() . '/img/users/banners/';
                $extension = $file->getClientOriginalExtension();

				// generate file name and check for existing
				$filename = str_random(20) . '.' . $extension;
				$existing_file = UserSite::where('banner', $filename)->get();
				while (count($existing_file) > 0) {
					$filename = str_random(20) . '.' . $extension;
				}

                $uploadSuccess   = $file->move($destinationPath, $filename);
    
                // open an image file
                $img = Image::make('img/users/banners/' . $filename);
    
                // now you are able to resize the instance
                $img->fit(1170, 340);
    
                // finally we save the image as a new image
                $img->save('img/users/banners/' . $filename);
				
				$old = $userSite->banner;
				if (is_file('img/users/banners/' . $old)) {
					unlink('img/users/banners/' . $old);
				}

                $data['banner'] = $filename;
            }
        }
		
		$userSite->update($data);
		// format checkbox values for database
		$data['hide_email'] = isset($data['hide_email']) ? 0 : 1;
		$data['hide_phone'] = isset($data['hide_phone']) ? 0 : 1;
		$data['hide_billing_address'] = isset($data['hide_billing_address']) ? 0 : 1;
		$data['hide_shipping_address'] = isset($data['hide_shipping_address']) ? 0 : 1;
		$user->update([
			'hide_email' => $data['hide_email'],
			'hide_phone' => $data['hide_phone'],
			'hide_billing_address' => $data['hide_billing_address'],
			'hide_shipping_address' => $data['hide_shipping_address'],
		]);

		return Redirect::back()->with('message', 'Site updated. <a target="_blank" href="//' . $user->public_id . '.' . Config::get('site.base_domain') . '">View site</a>.');
	}

	/**
	 * Remove the specified userSite from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		UserSite::destroy($id);

		return Redirect::route('userSite.index')->with('message', 'Site deleted.');
	}
	
	/**
	 * Remove userSites.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			UserSite::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('userSite.index')->with('message', 'Sites deleted.');
		}
		else {
			return Redirect::back()->with('message', 'UserSite deleted.');
		}
	}
	
	/**
	 * Diable userSites.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			UserSite::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('userSite.index')->with('message', 'Sites disabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserSite disabled.');
		}
	}
	
	/**
	 * Enable userSites.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			UserSite::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('userSite.index')->with('message', 'Sites enabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserSite enabled.');
		}
	}

}