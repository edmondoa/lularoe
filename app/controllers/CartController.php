<?php

class cartController extends \BaseController {

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
		
		// store product in session
		if (Session::get('products') == null) Session::put('products', []);
		$product = Product::find($data['product_id']);
		$product->purchase_quantity = $data['purchase_quantity'];
		Session::push('products', $product);
		return Redirect::route('cart')->with('message', 'Product added to cart. <a href="/store">Continue Shopping</a>.');
	}

	/**
	 * Display the specified cart.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$organizer = User::find(Session::get('organizer_id'));
		return View::make('cart.show', compact('organizer'));
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
	 * Remove the specified product from session storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function remove($index)
	{
		Session::forget('products.' . $index);
		return 'Product removed from cart';
	}

	/**
	 * Change the quantity of the specified product in product storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function changeQuantity()
	{
		$data = Input::all();

		$product = Session::get('products');
		if (isset($product[$data['index']])) {
			return $product[$data['index']]->purchase_quantity = $data['purchase_quantity'];
		}
		Session::put('products', $product);
		return true;
		return 'Purchase quantity set to ' . $data['purchase_quantity'];
	}

}