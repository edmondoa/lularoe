<?php

class userProductController extends \BaseController {

	// data only
	public function getAllUserProducts(){
		return UserProduct::all();
	}

	/**
	 * Display a listing of userProducts
	 *
	 * @return Response
	 */
	public function index()
	{
		$userProducts = UserProduct::all();

		return View::make('userProduct.index', compact('userProducts'));
	}

	/**
	 * Show the form for creating a new userProduct
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('userProduct.create');
	}

	/**
	 * Store a newly created userProduct in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), UserProduct::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		UserProduct::create($data);

		return Redirect::route('userProduct.index')->with('message', 'UserProduct created.');
	}

	/**
	 * Display the specified userProduct.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$userProduct = UserProduct::findOrFail($id);

		return View::make('userProduct.show', compact('userProduct'));
	}

	/**
	 * Show the form for editing the specified userProduct.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$userProduct = UserProduct::find($id);

		return View::make('userProduct.edit', compact('userProduct'));
	}

	/**
	 * Update the specified userProduct in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$userProduct = UserProduct::findOrFail($id);

		$validator = Validator::make($data = Input::all(), UserProduct::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$userProduct->update($data);

		return Redirect::route('userProducts.show')->with('message', 'UserProduct updated.');
	}

	/**
	 * Remove the specified userProduct from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		UserProduct::destroy($id);

		return Redirect::route('userProduct.index')->with('message', 'UserProduct deleted.');
	}
	
	/**
	 * Remove userProducts.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			UserProduct::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'UserProducts deleted.');
		}
		else {
			return Redirect::back()->with('message', 'UserProduct deleted.');
		}
	}
	
	/**
	 * Diable userProducts.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			UserProduct::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'UserProducts disabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserProduct disabled.');
		}
	}
	
	/**
	 * Enable userProducts.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			UserProduct::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'UserProducts enabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserProduct enabled.');
		}
	}

}