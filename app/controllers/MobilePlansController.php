<?php 

class MobilePlansController extends \BaseController
{
	protected $mobilePlans;

	public function __construct(MobilePlans $mobilePlans)
	{
		$this->mobilePlans = $mobilePlans;
	}

	public function index()
	{
    	$mobilePlans = $this->mobilePlans->all();
        $this->layout->content = \View::make('mobilePlans.index', compact('mobilePlans'));
	}

	public function create()
	{
        $this->layout->content = \View::make('mobilePlans.create');
	}

	public function store()
	{
        $this->mobilePlans->store(\Input::only('name','blurb','description'));
        return \Redirect::route('mobilePlans.index');
	}

	public function show($id)
	{
        $mobilePlans = $this->mobilePlans->find($id);
        $this->layout->content = \View::make('mobilePlans.show')->with('mobilePlans', $mobilePlans);
	}

	public function edit($id)
	{
        $mobilePlans = $this->mobilePlans->find($id);
        $this->layout->content = \View::make('mobilePlans.edit')->with('mobilePlans', $mobilePlans);
	}

	public function update($id)
	{
        $this->mobilePlans->find($id)->update(\Input::only('name','blurb','description'));
        return \Redirect::route('mobilePlans.show', $id);
	}

	public function destroy($id)
	{
        $this->mobilePlans->destroy($id);
        return \Redirect::route('mobilePlans.index');
	}

}
