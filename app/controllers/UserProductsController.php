<?php 

class UserProductsController extends \BaseController
{
	protected $userProducts;

	public function __construct(UserProducts $userProducts)
	{
		$this->userProducts = $userProducts;
	}

	public function index()
	{
    	$userProducts = $this->userProducts->all();
        $this->layout->content = \View::make('userProducts.index', compact('userProducts'));
	}

	public function create()
	{
        $this->layout->content = \View::make('userProducts.create');
	}

	public function store()
	{
        $this->userProducts->store(\Input::only('product_id'));
        return \Redirect::route('userProducts.index');
	}

	public function show($id)
	{
        $userProducts = $this->userProducts->find($id);
        $this->layout->content = \View::make('userProducts.show')->with('userProducts', $userProducts);
	}

	public function edit($id)
	{
        $userProducts = $this->userProducts->find($id);
        $this->layout->content = \View::make('userProducts.edit')->with('userProducts', $userProducts);
	}

	public function update($id)
	{
        $this->userProducts->find($id)->update(\Input::only('product_id'));
        return \Redirect::route('userProducts.show', $id);
	}

	public function destroy($id)
	{
        $this->userProducts->destroy($id);
        return \Redirect::route('userProducts.index');
	}

}
