<?php 

class UserRanksController extends \BaseController
{
	protected $userRanks;

	public function __construct(UserRanks $userRanks)
	{
		$this->userRanks = $userRanks;
	}

	public function index()
	{
    	$userRanks = $this->userRanks->all();
        $this->layout->content = \View::make('userRanks.index', compact('userRanks'));
	}

	public function create()
	{
        $this->layout->content = \View::make('userRanks.create');
	}

	public function store()
	{
        $this->userRanks->store(\Input::only('user_id','rank_id'));
        return \Redirect::route('userRanks.index');
	}

	public function show($id)
	{
        $userRanks = $this->userRanks->find($id);
        $this->layout->content = \View::make('userRanks.show')->with('userRanks', $userRanks);
	}

	public function edit($id)
	{
        $userRanks = $this->userRanks->find($id);
        $this->layout->content = \View::make('userRanks.edit')->with('userRanks', $userRanks);
	}

	public function update($id)
	{
        $this->userRanks->find($id)->update(\Input::only('user_id','rank_id'));
        return \Redirect::route('userRanks.show', $id);
	}

	public function destroy($id)
	{
        $this->userRanks->destroy($id);
        return \Redirect::route('userRanks.index');
	}

}
