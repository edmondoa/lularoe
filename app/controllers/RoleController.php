<?php 

class RoleController extends \BaseController
{
	protected $role;

	public function __construct(Role $role)
	{
		$this->role = $role;
	}

	public function index()
	{
    	$roles = $this->role->all();
        $this->layout->content = \View::make('role.index', compact('roles'));
	}

	public function create()
	{
        $this->layout->content = \View::make('role.create');
	}

	public function store()
	{
        $this->role->store(\Input::only('name','disabled'));
        return \Redirect::route('role.index');
	}

	public function show($id)
	{
        $role = $this->role->find($id);
        $this->layout->content = \View::make('role.show')->with('role', $role);
	}

	public function edit($id)
	{
        $role = $this->role->find($id);
        $this->layout->content = \View::make('role.edit')->with('role', $role);
	}

	public function update($id)
	{
        $this->role->find($id)->update(\Input::only('name','disabled'));
        return \Redirect::route('role.show', $id);
	}

	public function destroy($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->role->destroy($id);
			}
			return \Redirect::route('role.index');
		}
		else {
	        $this->role->destroy($id);
	        return \Redirect::route('role.index');
		}
	}
	
	public function delete($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->role->destroy($id);
			}
			return \Redirect::route('role.index')->with('message', 'Roles deleted.');;
		}
		else {
	        $this->role->destroy($id);
	        return \Redirect::route('role.index')->with('message', 'Role deleted.');;
		}
	}
	
	public function disable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->role->where('id', $id)->update(array('disabled' => 1));
			}
			return \Redirect::route('role.index')->with('message', 'Roles disabled.');
		}
		else {
	        $this->role->where('id', $id)->update(array('disabled' => 1));
	        return \Redirect::route('role.index')->with('message', 'Role disabled.');;
		}
	}
	
	public function enable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->role->where('id', $id)->update(array('disabled' => NULL));
			}
			return \Redirect::route('role.index')->with('message', 'Roles enabled.');;
		}
		else {
	        $this->role->where('id', $id)->update(array('disabled' => NULL));
	        return \Redirect::route('role.index')->with('message', 'Role enabled.');;
		}
	}
	
}
