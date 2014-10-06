<?php 

class RanksController extends \BaseController
{
	protected $ranks;

	public function __construct(Ranks $ranks)
	{
		$this->ranks = $ranks;
	}

	public function index()
	{
    	$ranks = $this->ranks->all();
        $this->layout->content = \View::make('ranks.index', compact('ranks'));
	}

	public function create()
	{
        $this->layout->content = \View::make('ranks.create');
	}

	public function store()
	{
        $this->ranks->store(\Input::only('name'));
        return \Redirect::route('ranks.index');
	}

	public function show($id)
	{
        $ranks = $this->ranks->find($id);
        $this->layout->content = \View::make('ranks.show')->with('ranks', $ranks);
	}

	public function edit($id)
	{
        $ranks = $this->ranks->find($id);
        $this->layout->content = \View::make('ranks.edit')->with('ranks', $ranks);
	}

	public function update($id)
	{
        $this->ranks->find($id)->update(\Input::only('name'));
        return \Redirect::route('ranks.show', $id);
	}

	public function destroy($id)
	{
        $this->ranks->destroy($id);
        return \Redirect::route('ranks.index');
	}

}
