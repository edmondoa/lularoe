<?php

class leadController extends \BaseController {

	/**
	 * Display a listing of leads
	 *
	 * @return Response
	 */
	public function index()
	{
		$leads = Lead::all();

		return View::make('lead.index', compact('leads'));
	}

	/**
	 * Show the form for creating a new lead
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('lead.create');
	}

	/**
	 * Store a newly created lead in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Lead::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Lead::create($data);
		
		if (isset($data['from_opportunity'])) {
			Session::put('already_submitted', 1);
			return Redirect::back()->with('message', 'Your application has been received.');
		}
		else {
			return Redirect::route('leads.index')->with('message', 'Lead created.');
		}
	}

	/**
	 * Display the specified lead.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$lead = Lead::findOrFail($id);
		return View::make('lead.show', compact('lead'));
	}

	/**
	 * Show the form for editing the specified lead.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$lead = Lead::find($id);

		return View::make('lead.edit', compact('lead'));
	}

	/**
	 * Update the specified lead in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$lead = Lead::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Lead::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$lead->update($data);

		return Redirect::route('leads.show', $id)->with('message', 'Lead updated.');
	}

	/**
	 * Remove the specified lead from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lead::destroy($id);

		return Redirect::route('leads.index')->with('message', 'Lead deleted.');
	}
	
	/**
	 * Remove leads.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Lead::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('leads.index')->with('message', 'Leads deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Lead deleted.');
		}
	}
	
	/**
	 * Diable leads.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Lead::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('leads.index')->with('message', 'Leads disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Lead disabled.');
		}
	}
	
	/**
	 * Enable leads.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Lead::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('leads.index')->with('message', 'Leads enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Lead enabled.');
		}
	}

}