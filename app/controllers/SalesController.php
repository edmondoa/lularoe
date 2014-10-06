<?php 

class SalesController extends \BaseController
{
	protected $sales;

	public function __construct(Sales $sales)
	{
		$this->sales = $sales;
	}

	public function index()
	{
    	$sales = $this->sales->all();
        $this->layout->content = \View::make('sales.index', compact('sales'));
	}

	public function create()
	{
        $this->layout->content = \View::make('sales.create');
	}

	public function store()
	{
        $this->sales->store(\Input::only('product_id','user_id','sponsor_id','quantity'));
        return \Redirect::route('sales.index');
	}

	public function show($id)
	{
        $sales = $this->sales->find($id);
        $this->layout->content = \View::make('sales.show')->with('sales', $sales);
	}

	public function edit($id)
	{
        $sales = $this->sales->find($id);
        $this->layout->content = \View::make('sales.edit')->with('sales', $sales);
	}

	public function update($id)
	{
        $this->sales->find($id)->update(\Input::only('product_id','user_id','sponsor_id','quantity'));
        return \Redirect::route('sales.show', $id);
	}

	public function destroy($id)
	{
        $this->sales->destroy($id);
        return \Redirect::route('sales.index');
	}

}
