<?php

class RoleController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllRoles(){
		$roles = Role::all();
		foreach ($roles as $role)
		{
			if (strtotime($role['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$role['new'] = 1;
			}
		}
		return $roles;
	}

	/**
	 * Display a listing of roles
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::all();

		return View::make('role.index', compact('roles'));
	}

	/**
	 * Show the form for creating a new role
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('role.create');
	}

	/**
	 * Store a newly created role in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Role::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Role::create($data);

		return Redirect::route('roles.index')->with('message', 'Role created.');
	}

	/**
	 * Display the specified role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role = Role::findOrFail($id);

		return View::make('role.show', compact('role'));
	}

	/**
	 * Show the form for editing the specified role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::find($id);

		return View::make('role.edit', compact('role'));
	}

	/**
	 * Update the specified role in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$role = Role::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Role::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$role->update($data);

		return Redirect::route('roles.show', $id)->with('message', 'Role updated.');
	}

	/**
	 * Remove the specified role from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Role::destroy($id);

		return Redirect::route('roles.index')->with('message', 'Role deleted.');
	}
	
	/**
	 * Remove roles.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Role::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('roles.index')->with('message', 'Roles deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Role deleted.');
		}
	}
	
	/**
	 * Diable roles.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Role::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('roles.index')->with('message', 'Roles disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Role disabled.');
		}
	}
	
	/**
	 * Enable roles.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Role::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('roles.index')->with('message', 'Roles enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Role enabled.');
		}
	}

}