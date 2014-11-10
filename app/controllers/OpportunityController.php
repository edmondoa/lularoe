<?php

class opportunityController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllOpportunities(){
		$opportunities = Opportunity::all();
		foreach ($opportunities as $opportunity)
		{
			if (strtotime($opportunity['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$opportunity['new'] = 1;
			}
		}
		return $opportunities;
	}

	/**
	 * Display a listing of opportunities
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('opportunity.index');
	}

	/**
	 * Show the form for creating a new opportunity
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('opportunity.create');
	}

	/**
	 * Store a newly created opportunity in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Opportunity::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// format deadline for database
		$data['deadline'] = strtotime($data['deadline']);

		// format checkbox values for database
		$data['include_form'] = isset($data['include_form']) ? 1 : 0;
		$data['public'] = isset($data['public']) ? 1 : 0;
		$data['customers'] = isset($data['customers']) ? 1 : 0;
		$data['reps'] = isset($data['reps']) ? 1 : 0;

		Opportunity::create($data);

		return Redirect::route('opportunities.index')->with('message', 'Opportunity created.');
	}

	/**
	 * Display the specified opportunity.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$opportunity = Opportunity::findOrFail($id);

		return View::make('opportunity.show', compact('opportunity'));
	}

	/**
	 * Show the form for editing the specified opportunity.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$opportunity = Opportunity::find($id);

		return View::make('opportunity.edit', compact('opportunity'));
	}

	/**
	 * Update the specified opportunity in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$opportunity = Opportunity::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Opportunity::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// format deadline for database
		$data['deadline'] = strtotime($data['deadline']);

		// format checkbox values for database
		$data['include_form'] = isset($data['include_form']) ? 1 : 0;
		$data['public'] = isset($data['public']) ? 1 : 0;
		$data['customers'] = isset($data['customers']) ? 1 : 0;
		$data['reps'] = isset($data['reps']) ? 1 : 0;

		$opportunity->update($data);

		return Redirect::route('opportunities.show', $id)->with('message', 'Opportunity updated.');
	}

	/**
	 * Remove the specified opportunity from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Opportunity::destroy($id);

		return Redirect::route('opportunities.index')->with('message', 'Opportunity deleted.');
	}
	
	/**
	 * Remove opportunities.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Opportunity::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('opportunities.index')->with('message', 'Opportunities deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Opportunity deleted.');
		}
	}
	
	/**
	 * Diable opportunities.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Opportunity::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('opportunities.index')->with('message', 'Opportunities disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Opportunity disabled.');
		}
	}
	
	/**
	 * Enable opportunities.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Opportunity::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('opportunities.index')->with('message', 'Opportunities enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Opportunity enabled.');
		}
	}

}