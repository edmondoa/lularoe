<?php 

class ProductsController extends \BaseController
{
	protected $products;

	public function __construct(Products $products)
	{
		$this->products = $products;
	}

	public function index()
	{
    	$products = $this->products->all();
        $this->layout->content = \View::make('products.index', compact('products'));
	}

	public function create()
	{
        $this->layout->content = \View::make('products.create');
	}

	public function store()
	{
        $this->products->store(\Input::only('name','blurb','description','price','quantity'));
        return \Redirect::route('products.index');
	}

	public function show($id)
	{
        $products = $this->products->find($id);
        $this->layout->content = \View::make('products.show')->with('products', $products);
	}

	public function edit($id)
	{
        $products = $this->products->find($id);
        $this->layout->content = \View::make('products.edit')->with('products', $products);
	}

	public function update($id)
	{
        $this->products->find($id)->update(\Input::only('name','blurb','description','price','quantity'));
        return \Redirect::route('products.show', $id);
	}

	public function destroy($id)
	{
        $this->products->destroy($id);
        return \Redirect::route('products.index');
	}

}
