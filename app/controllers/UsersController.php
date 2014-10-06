<?php 

class UsersController extends \BaseController
{
	protected $users;

	public function __construct(Users $users)
	{
		$this->users = $users;
	}

	public function index()
	{
    	$users = $this->users->all();
        $this->layout->content = \View::make('users.index', compact('users'));
	}

	public function create()
	{
        $this->layout->content = \View::make('users.create');
	}

	public function store()
	{
        $this->users->store(\Input::only('first_name','last_name','email','password','key','code','phone','role_id','sponsor_id','mobile_plan_id','min_commission'));
        return \Redirect::route('users.index');
	}

	public function show($id)
	{
        $users = $this->users->find($id);
        $this->layout->content = \View::make('users.show')->with('users', $users);
	}

	public function edit($id)
	{
        $users = $this->users->find($id);
        $this->layout->content = \View::make('users.edit')->with('users', $users);
	}

	public function update($id)
	{
        $this->users->find($id)->update(\Input::only('first_name','last_name','email','password','key','code','phone','role_id','sponsor_id','mobile_plan_id','min_commission'));
        return \Redirect::route('users.show', $id);
	}

	public function destroy($id)
	{
        $this->users->destroy($id);
        return \Redirect::route('users.index');
	}

}
