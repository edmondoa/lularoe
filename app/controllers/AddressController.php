<?php

class addressController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllRecords(){
		return Address::all();
	}

	/**
	 * Display a listing of addresses
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$addresses = Address::all();
			return View::make('address.index', compact('addresses'));
		}
	}

	/**
	 * Show the form for creating a new address
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('address.create');
	}

	/**
	 * Store a newly created address in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Address::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if (Auth::user()->hasRole(['Rep'])) {
			$data['addressable_id'] = Auth::user()->id;
			$data['addressable_type'] = 'User';
		}
		Address::create($data);
		if (Auth::user()->hasRole(['Rep'])) return Redirect::route('settings');
		else return Redirect::back()->with('message', 'Address created.');
	}

	/**
	 * Display the specified address.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$address = Address::findOrFail($id);
		if (Auth::user()->hasRole(['Superadmin', 'Admin']) || $address->addressable_id == Auth::user()->id) {
			return View::make('address.show', compact('address'));
		}
	}

	/**
	 * Show the form for editing the specified address.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$address = Address::find($id);
		if ($address->addressable_type == 'Party') {
			$party = Party::where('id', $address->addressable_id)->get()->first();
			if (isset($party) && $party->organizer_id == Auth::user()->id) $party_organizer = true;
		};
		if (Auth::user()->hasRole(['Superadmin', 'Admin']) || $address->addressable_id == Auth::user()->id || isset($party_organizer)) {
			return View::make('address.edit', compact('address'));
		}
	}

	/**
	 * Update the specified address in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$address = Address::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Address::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$address->update($data);

		return Redirect::to(Session::get('previous_page_2'))->with('message', 'Address updated.');
	}

	/**
	 * Remove the specified address from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$address = Address::find($id);
		if (Auth::user()->hasRole(['Superadmin', 'Admin']) || $address->addressable_id = Auth::user()->id) {
			Address::destroy($id);
			if (Auth::user()->hasRole(['Rep'])) return Redirect::route('settings')->with('message', 'Address deleted.');
			else return Redirect::route('addresses.index')->with('message', 'Address deleted.');
		}
	}
	
	/**
	 * Remove addresses.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Address::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('addresses.index')->with('message', 'Addresses deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Address deleted.');
		}
	}
	
	/**
	 * Diable addresses.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Address::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('addresses.index')->with('message', 'Addresses disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Address disabled.');
		}
	}
	
	/**
	 * Enable addresses.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Address::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('addresses.index')->with('message', 'Addresses enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Address enabled.');
		}
	}

}