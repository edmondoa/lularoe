<?php

class productController extends \BaseController {

	// data only
	public function getAllProducts(){
		return Product::all();
	}

	/**
	 * Display a listing of products
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::all();

		return View::make('product.index', compact('products'));
	}

	/**
	 * Show the form for creating a new product
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('product.create');
	}

	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Product::create($data);

		return Redirect::route('product.index')->with('message', 'Product created.');
	}

	/**
	 * Display the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::findOrFail($id);

		return View::make('product.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);

		return View::make('product.edit', compact('product'));
	}

	/**
	 * Update the specified product in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = Product::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$product->update($data);

		return Redirect::route('products.index')->with('message', 'Product updated.');
	}

	/**
	 * Remove the specified product from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Product::destroy($id);

		return Redirect::route('product.index')->with('message', 'Product deleted.');
	}
	
	/**
	 * Remove products.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Product::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'Products deleted.');
		}
		else {
			return Redirect::route('product.index')->with('message', 'Product deleted.');
		}
	}
	
	/**
	 * Diable products.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Product::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'Products disabled.');
		}
		else {
			return Redirect::route('product.show', $ids[0])->with('message', 'Product disabled.');
		}
	}
	
	/**
	 * Enable products.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Product::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'Products enabled.');
		}
		else {
			return Redirect::route('product.show', $ids[0])->with('message', 'Product enabled.');
		}
	}

}