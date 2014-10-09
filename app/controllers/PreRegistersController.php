<?php

class PreRegistersController extends \BaseController {

	/**
	 * Display a listing of preregisters
	 *
	 * @return Response
	 */
	public function index()
	{
		$preregisters = Preregister::all();

		return View::make('preregisters.index', compact('preregisters'));
	}

	/**
	 * Show the form for creating a new preregister
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('preregisters.create');
	}

	/**
	 * Store a newly created preregister in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Preregister::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Preregister::create($data);

		return Redirect::route('preregisters.index');
	}

	/**
	 * Display the specified preregister.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$preregister = Preregister::findOrFail($id);

		return View::make('preregisters.show', compact('preregister'));
	}

	/**
	 * Show the form for editing the specified preregister.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$preregister = Preregister::find($id);

		return View::make('preregisters.edit', compact('preregister'));
	}

	/**
	 * Update the specified preregister in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$preregister = Preregister::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Preregister::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$preregister->update($data);

		return Redirect::route('preregisters.index');
	}

	/**
	 * Remove the specified preregister from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Preregister::destroy($id);

		return Redirect::route('preregisters.index');
	}

}
