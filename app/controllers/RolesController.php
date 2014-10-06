<?php 

class RolesController extends \BaseController
{
	protected $roles;

	public function __construct(Roles $roles)
	{
		$this->roles = $roles;
	}

	public function index()
	{
    	$roles = $this->roles->all();
        $this->layout->content = \View::make('roles.index', compact('roles'));
	}

	public function create()
	{
        $this->layout->content = \View::make('roles.create');
	}

	public function store()
	{
        $this->roles->store(\Input::only('name'));
        return \Redirect::route('roles.index');
	}

	public function show($id)
	{
        $roles = $this->roles->find($id);
        $this->layout->content = \View::make('roles.show')->with('roles', $roles);
	}

	public function edit($id)
	{
        $roles = $this->roles->find($id);
        $this->layout->content = \View::make('roles.edit')->with('roles', $roles);
	}

	public function update($id)
	{
        $this->roles->find($id)->update(\Input::only('name'));
        return \Redirect::route('roles.show', $id);
	}

	public function destroy($id)
	{
        $this->roles->destroy($id);
        return \Redirect::route('roles.index');
	}

}
