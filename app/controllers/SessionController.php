<?php

class SessionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /sessions
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /sessions/create
	 *
	 * @return Response
	 */
	public function create()
	{
	 	//dont' need a client to login twice so if they are logged in it will take them to their default area
	 	if(Auth::check())
		{
			return Redirect::intended('/dashboard');
		}
		$title = 'Log In';
		return View::make('sessions.create', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /sessions
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$note = '';
		if (strpos($input['password'],' ')) $note = ' Note: the password you entered included one or more spaces. Was this on purpose?';
		$attempt = Auth::attempt([
				'email' => $input['email'],
				'password' => $input['password']
			], false);
		if($attempt)
		{
			return Redirect::intended('dashboard');		
		} 
		else
		{
			return Redirect::back()->with('message_danger', 'Incorrect email or password.' . $note);
		}
	}

	/**
	 * Display the specified resource.
	 * GET /sessions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /sessions/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /sessions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /sessions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::home();
	}

}