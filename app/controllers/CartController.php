<?php

class CartController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllCarts(){
		$carts = Cart::all();
		foreach ($carts as $cart)
		{
			if (strtotime($cart['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$cart['new'] = 1;
			}
		}
		return $carts;
	}

	/**
	 * Display a listing of carts
	 *
	 * @return Response
	 */
	public function index()
	{
		$carts = Cart::all();

		return View::make('cart.index', compact('carts'));
	}

	/**
	 * Show the form for creating a new cart
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cart.create');
	}

	/**
	 * Store a newly created cart in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Cart::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Cart::create($data);

		return Redirect::route('carts.index')->with('message', 'Cart created.');
	}

	/**
	 * Display the specified cart.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$cart = Cart::findOrFail($id);

		return View::make('cart.show', compact('cart'));
	}

	/**
	 * Show the form for editing the specified cart.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cart = Cart::find($id);

		return View::make('cart.edit', compact('cart'));
	}

	/**
	 * Update the specified cart in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$cart = Cart::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Cart::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$cart->update($data);

		return Redirect::route('carts.show', $id)->with('message', 'Cart updated.');
	}

	/**
	 * Remove the specified cart from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cart::destroy($id);

		return Redirect::route('carts.index')->with('message', 'Cart deleted.');
	}
	
	/**
	 * Remove carts.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Cart::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('carts.index')->with('message', 'Carts deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Cart deleted.');
		}
	}
	
	/**
	 * Diable carts.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Cart::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('carts.index')->with('message', 'Carts disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Cart disabled.');
		}
	}
	
	/**
	 * Enable carts.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Cart::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('carts.index')->with('message', 'Carts enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Cart enabled.');
		}
	}

}