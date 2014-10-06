<?php 

class CommissionsController extends \BaseController
{
	protected $commissions;

	public function __construct(Commissions $commissions)
	{
		$this->commissions = $commissions;
	}

	public function index()
	{
    	$commissions = $this->commissions->all();
        $this->layout->content = \View::make('commissions.index', compact('commissions'));
	}

	public function create()
	{
        $this->layout->content = \View::make('commissions.create');
	}

	public function store()
	{
        $this->commissions->store(\Input::only('user_id','amount','description'));
        return \Redirect::route('commissions.index');
	}

	public function show($id)
	{
        $commissions = $this->commissions->find($id);
        $this->layout->content = \View::make('commissions.show')->with('commissions', $commissions);
	}

	public function edit($id)
	{
        $commissions = $this->commissions->find($id);
        $this->layout->content = \View::make('commissions.edit')->with('commissions', $commissions);
	}

	public function update($id)
	{
        $this->commissions->find($id)->update(\Input::only('user_id','amount','description'));
        return \Redirect::route('commissions.show', $id);
	}

	public function destroy($id)
	{
        $this->commissions->destroy($id);
        return \Redirect::route('commissions.index');
	}

}
