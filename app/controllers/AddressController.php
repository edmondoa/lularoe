<?php

class addressController extends \BaseController {

	// data only
	public function getAllAddresses(){
		return Address::all();
	}

	/**
	 * Display a listing of addresses
	 *
	 * @return Response
	 */
	public function index()
	{
		$addresses = Address::all();

		return View::make('address.index', compact('addresses'));
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

		Address::create($data);

		return Redirect::route('address.index')->with('message', 'Address created.');
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

		return View::make('address.show', compact('address'));
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

		return View::make('address.edit', compact('address'));
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

		return Redirect::route('addresses.show')->with('message', 'Address updated.');
	}

	/**
	 * Remove the specified address from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Address::destroy($id);

		return Redirect::route('address.index')->with('message', 'Address deleted.');
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
			return Redirect::route('product.index')->with('message', 'Addresses deleted.');
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
			return Redirect::route('product.index')->with('message', 'Addresses disabled.');
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
			return Redirect::route('product.index')->with('message', 'Addresses enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Address enabled.');
		}
	}

}