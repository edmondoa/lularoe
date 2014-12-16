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
		$rules['sponsor_id'] = 'required|numeric';
		$check_sponsor_id = User::where('public_id', $data['sponsor_id']);

		$validator = Validator::make($data,$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$data['password'] = Hash::make($data['password']);
		$data['email'] = strtolower($data['email']);
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
		Event::fire('rep.create', array('rep_id' => $user->id));
		//Auth::loginUsingId($user->id);
		return Redirect::to('users')->with('message', 'User created.');
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
			$user->role_name == 'Rep' ? $user->formatted_role_name = 'ISM' : $user->formatted_role_name = $user->role_name;
			
			// set unlabeled addresses to billing
			$address = $user->addresses()->first();
			if (isset($address) && $address->label == NULL) {
				$address->update(['label' => 'Billing']);
			}
			
			// make array of addresses set as visible by target user or viewable by current user
			$addresses = [];
			if (Address::where('addressable_id', $id)->where('label', 'Billing')->first() != NULL && ($user->hide_billing_address != true || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9)) $addresses[] = Address::where('addressable_id', $id)->where('label', 'Billing')->first();
			if (Address::where('addressable_id', $id)->where('label', 'Shipping')->first() != NULL && ($user->hide_shipping_address != true || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9)) $addresses[] = Address::where('addressable_id', $id)->where('label', 'Shipping')->first();
			// echo '<pre>'; print_r($user); echo '</pre>';
			// exit;
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
		if ($id === 0) 
		{
			return Redirect::back()->with('message', 'Unable to edit this user.');
		}
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id) {
			$user = User::find($id);
			
			return View::make('user.edit', compact('user'));
		}
	}

	/**
	 * Show the form for editing the specified user's privacy and communication preferences.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function privacy($id)
	{
		if ($id === 0) 
		{
			return Redirect::back()->with('message', 'Unable to edit this user.');
		}
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id) {
			$user = User::find($id);

			$checked = [];

			// format checkbox values for database
			$checked['hide_gender'] = $user->hide_gender == 1 ? 0 : 1;
			$checked['hide_dob'] = $user->hide_dob == 1 ? 0 : 1;
			$checked['hide_email'] = $user->hide_email == 1 ? 0 : 1;
			$checked['hide_phone'] = $user->hide_phone == 1 ? 0 : 1;
			$checked['hide_billing_address'] = $user->hide_billing_address == 1 ? 0 : 1;
			$checked['hide_shipping_address'] = $user->hide_shipping_address == 1 ? 0 : 1;
			$checked['block_email'] = $user->block_email == 1 ? 0 : 1;
			$checked['block_sms'] = $user->block_sms == 1 ? 0 : 1;
			
			return View::make('user.privacy', compact('user', 'checked'));
		}
	}

	/**
	 * Update the specified user's privacy and communications settings in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updatePrivacy($id)
	{
		if ($id === 0) 
		{
			return Redirect::back()->with('message', 'Unable to edit this user.');
		}
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id) 
		{
			$user = User::findOrFail($id);
			$data = Input::all();
			
			// format checkbox values for database
			$data['hide_gender'] = isset($data['hide_gender']) ? 0 : 1;
			$data['hide_dob'] = isset($data['hide_dob']) ? 0 : 1;
			$data['hide_email'] = isset($data['hide_email']) ? 0 : 1;
			$data['hide_phone'] = isset($data['hide_phone']) ? 0 : 1;
			$data['hide_billing_address'] = isset($data['hide_billing_address']) ? 0 : 1;
			$data['hide_shipping_address'] = isset($data['hide_shipping_address']) ? 0 : 1;
			$data['block_email'] = isset($data['block_email']) ? 0 : 1;
			$data['block_sms'] = isset($data['block_sms']) ? 0 : 1;
			
			$user->update($data);
			return Redirect::route('settings')->with('message', 'Preferences saved.');
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
		if ($id === 0) 
		{
			return Redirect::back()->with('message', 'Unable to edit this user.');
		}
		if (Auth::user()->hasRole(['Admin', 'Superadmin']) || Auth::user()->id == $id) 
		{
			$user = User::findOrFail($id);
			$old_user_data = $user;
			$rules = User::$rules;
			$rules['email'] = 'unique:users,email,' . $user->id;
			$rules['password'] = 'sometimes|confirmed|digits_between:8,25';
			//$rules['sponsor_id'] = 'required|digits';
			$data = Input::all();
			if (isset($data['phone'])) $data['phone'] = formatPhone($data['phone']);
			$validator = Validator::make($data, $rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			$data['password'] = Hash::make($data['password']);
			$data['email'] = strtolower($data['email']);
			$user->update($data);
			if($old_user_data->sponsor_id != $user->sponsor_id)
			{
				Event::fire('sponsor.update', array('rep_id' => $user->id));
			}
	
			return Redirect::route('users.show', $id)->with('message', 'Updates saved.');
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