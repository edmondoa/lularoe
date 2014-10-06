<?php 

class CartController extends \BaseController
{
	protected $cart;

	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
	}

	public function index()
	{
    	$carts = $this->cart->all();
        $this->layout->content = \View::make('cart.index', compact('carts'));
	}

	public function create()
	{
        $this->layout->content = \View::make('cart.create');
	}

	public function store()
	{
        $this->cart->store(\Input::only('product_id'));
        return \Redirect::route('cart.index');
	}

	public function show($id)
	{
        $cart = $this->cart->find($id);
        $this->layout->content = \View::make('cart.show')->with('cart', $cart);
	}

	public function edit($id)
	{
        $cart = $this->cart->find($id);
        $this->layout->content = \View::make('cart.edit')->with('cart', $cart);
	}

	public function update($id)
	{
        $this->cart->find($id)->update(\Input::only('product_id'));
        return \Redirect::route('cart.show', $id);
	}

	public function destroy($id)
	{
        $this->cart->destroy($id);
        return \Redirect::route('cart.index');
	}

}
