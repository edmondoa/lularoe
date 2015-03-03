<?php

class OpportunityController extends \BaseController {

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
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			return View::make('opportunity.create');
		}
	}

	/**
	 * Store a newly created opportunity in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$validator = Validator::make($data = Input::all(), Opportunity::$rules);
	
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
	
			// format deadline for database
			if (isset($data['deadline'])) $data['deadline'] = strtotime($data['deadline']);
	
			// format checkbox values for database
			$data['include_form'] = isset($data['include_form']) ? 1 : 0;
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
	
			Opportunity::create($data);
	
			return Redirect::route('opportunities.index')->with('message', 'Promotion created.');
		}
	}

	/**
	 * Display the specified opportunity.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$opportunity = Opportunity::findOrFail($id);

			return View::make('opportunity.show', compact('opportunity'));
		}
	}

	/**
	 * Show the form for editing the specified opportunity.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$opportunity = Opportunity::find($id);
			if ($opportunity->deadline != 0) {
				$deadline = $opportunity->formatted_deadline_date . ', ' . $opportunity->formatted_deadline_time;
			}
			else $deadline = '';
			return View::make('opportunity.edit', compact('opportunity', 'deadline'));
		}
	}

	/**
	 * Update the specified opportunity in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$opportunity = Opportunity::findOrFail($id);
	
			$validator = Validator::make($data = Input::all(), Opportunity::$rules);
	
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
	
			// format deadline for database
			if (isset($data['deadline'])) $data['deadline'] = strtotime($data['deadline']);
	
			// format checkbox values for database
			$data['include_form'] = isset($data['include_form']) ? 1 : 0;
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
	
			$opportunity->update($data);
	
			return Redirect::route('opportunities.show', $id)->with('message', 'Promotion updated.');
			}
	}

	/**
	 * Remove the specified opportunity from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			Opportunity::destroy($id);
	
			return Redirect::route('opportunities.index')->with('message', 'Promotion deleted.');
		}
	}
	
	/**
	 * Remove opportunities.
	 */
	public function delete()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			foreach (Input::get('ids') as $id) {
				Opportunity::destroy($id);
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('opportunities.index')->with('message', 'Promotions deleted.');
			}
			else {
				return Redirect::back()->with('message', 'Opportunity deleted.');
			}
		}
	}
	
	/**
	 * Diable opportunities.
	 */
	public function disable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			foreach (Input::get('ids') as $id) {
				Opportunity::find($id)->update(['disabled' => 1]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('opportunities.index')->with('message', 'Promotions disabled.');
			}
			else {
				return Redirect::back()->with('message', 'Opportunity disabled.');
			}
		}
	}
	
	/**
	 * Enable opportunities.
	 */
	public function enable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			foreach (Input::get('ids') as $id) {
				Opportunity::find($id)->update(['disabled' => 0]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('opportunities.index')->with('message', 'Promotions enabled.');
			}
			else {
				return Redirect::back()->with('message', 'Opportunity enabled.');
			}
		}
	}

}