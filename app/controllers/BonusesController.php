<?php 

class BonusesController extends \BaseController
{
	protected $bonuses;

	public function __construct(Bonuses $bonuses)
	{
		$this->bonuses = $bonuses;
	}

	public function index()
	{
    	$bonuses = $this->bonuses->all();
        $this->layout->content = \View::make('bonuses.index', compact('bonuses'));
	}

	public function create()
	{
        $this->layout->content = \View::make('bonuses.create');
	}

	public function store()
	{
        $this->bonuses->store(\Input::only('user_id','eight_in_eight','twelve_in_twelve'));
        return \Redirect::route('bonuses.index');
	}

	public function show($id)
	{
        $bonuses = $this->bonuses->find($id);
        $this->layout->content = \View::make('bonuses.show')->with('bonuses', $bonuses);
	}

	public function edit($id)
	{
        $bonuses = $this->bonuses->find($id);
        $this->layout->content = \View::make('bonuses.edit')->with('bonuses', $bonuses);
	}

	public function update($id)
	{
        $this->bonuses->find($id)->update(\Input::only('user_id','eight_in_eight','twelve_in_twelve'));
        return \Redirect::route('bonuses.show', $id);
	}

	public function destroy($id)
	{
        $this->bonuses->destroy($id);
        return \Redirect::route('bonuses.index');
	}

}
