<?php

class userController extends \BaseController {

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return View::make('user.index');
		}
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			return View::make('user.create');
		}
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		$data['phone'] = formatPhone($data['phone']);
		$rules = User::$rules;
		$rules['email'] = 'required|unique:users,email';
		$rules['address_1'] = 'required';
		$rules['address_2'] = 'sometimes';
		$rules['city'] = 'required';
		$rules['state'] = 'required';
		$rules['zip'] = 'required|digits_between:5,10';
		$rules['dob'] = 'required|before:'.date('Y-m-d',strtotime('18 years ago'));
		$rules['password'] = 'required|confirmed|digits_between:8,12';
		$rules['sponsor_id'] = 'required|digits';
		$check_sponsor_id = User::where('public_id', $data['sponsor_id']);

		$validator = Validator::make($data,$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$data['password'] = Hash::make($data['password']);
		$user = User::create($data);
		
		// store address
	    $address = Address::create([
	    	'address'=>$data['address_1'],
	    	'address2'=>$data['address_2'],
	    	'city'=>$data['city'],
	    	'state'=>$data['state'],
	    	'zip'=>$data['zip'],
	    	]);
		$user->addresses()->save($address);
		
        // process and store image
        if (Input::file('image')) {
            // upload and link to image
            $filename = '';
            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $destinationPath = public_path() . '/img/avatars/';
                $extension = $file->getClientOriginalExtension();
                $filename = str_random(20) . '.' . $extension;
                $uploadSuccess   = $file->move($destinationPath, $filename);
    
                // open an image file
                $img = Image::make('img/avatars/' . $filename);
    
                // now you are able to resize the instance
                $img->fit(50, 50);
    
                // finally we save the image as a new image
                $img->save('img/avatars/' . $filename);
    
                $data['image'] = $filename;
            }
        }
        else if ($data['icon'] != '') {
            $data['image'] = 'icons/' . $data['icon'] . '.png';
        }
		
		// log in new user
		Event::fire('rep.create', array('rep_id' => $user->id));
		Auth::loginUsingId($user->id);
		return Redirect::to('users.index');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id || Auth::user()->hasRepInDownline($id) || Auth::user()->sponsor_id == $id) {
			$user = User::findOrFail($id);
			$addresses = User::find($id)->addresses;
			return View::make('user.show', compact('user', 'addresses'));
		}
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id) {
			$user = User::find($id);
			
			return View::make('user.edit', compact('user'));
		}
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id) {
			$user = User::findOrFail($id);
			$rules = User::$rules;
			$rules['email'] = 'unique:users,email,' . $user->id;
			$rules['password'] = 'sometimes|confirmed|digits_between:8,12';
			//$rules['sponsor_id'] = 'required|digits';
			$data = Input::all();
			$data['phone'] = formatPhone($data['phone']);
			$validator = Validator::make($data, $rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			$data['password'] = Hash::make($data['password']);
			$user->update($data);
	
			return Redirect::route('users.show', $id)->with('message', 'User updated.');
		}
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			User::destroy($id);
	
			return Redirect::route('users.index')->with('message', 'User deleted.');
		}
	}

	/**
	 * Remove users.
	 */
	public function delete()
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			foreach (Input::get('ids') as $id) {
				User::destroy($id);
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('users.index')->with('message', 'Users deleted.');
			}
			else {
				return Redirect::back()->with('message', 'User deleted.');
			}
		}
	}

	/**
	 * Diable users.
	 */
	public function disable()
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			foreach (Input::get('ids') as $id) {
				User::find($id)->update(['disabled' => 1]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('users.index')->with('message', 'Users disabled.');
			}
			else {
				return Redirect::back()->with('message', 'User disabled.');
			}
		}
	}

	/**
	 * Enable users.
	 */
	public function enable()
	{
		if (Auth::user()->hasRole(['Admin', 'Superadmin'])) {
			foreach (Input::get('ids') as $id) {
				User::find($id)->update(['disabled' => 0]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('users.index')->with('message', 'Users enabled.');
			}
			else {
				return Redirect::back()->with('message', 'User enabled.');
			}
		}
	}

}