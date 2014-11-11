<?php

class uventController extends \BaseController {


	/**
	 * Display a listing of uvents
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('event.index');
	}
	
	/**
	 * Display a listing of public uvents
	 *
	 * @return Response
	 */
	public function publicIndex()
	{
		return View::make('event.public_index');
	}

	/**
	 * Show the form for creating a new uvent
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			return View::make('event.create');
		}
	}

	/**
	 * Store a newly created uvent in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$validator = Validator::make($data = Input::all(), Uvent::$rules);
			
			// echo '<pre>'; print_r($data); echo '</pre>';
			// exit;
			
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
			// format dates and times for database
			$data['date_start'] = strtotime($data['date_start']);
			$data['date_end'] = strtotime($data['date_end']);

			// format checkbox values for database
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
			$data['editors'] = isset($data['editors']) ? 1 : 0;
			$data['admins'] = isset($data['admins']) ? 1 : 0;
			
			Uvent::create($data);
	
			return Redirect::route('events.index')->with('message', 'Event created.');
		}
	}

	/**
	 * Display the specified uvent.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$event = Uvent::findOrFail($id);
		return View::make('event.show', compact('event'));
	}

	/**
	 * Display the specified uvent.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function publicShow($id)
	{
		$event = Uvent::findOrFail($id);
		return View::make('event.public_show', compact('event'));
	}

	/**
	 * Show the form for editing the specified uvent.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$event = Uvent::find($id);
	
			return View::make('event.edit', compact('event'));
		}
	}

	/**
	 * Update the specified uvent in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$event = Uvent::findOrFail($id);
	
			$validator = Validator::make($data = Input::all(), Uvent::$rules);
	
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
			// format dates and times for database
			$data['date_start'] = strtotime($data['date_start']);
			$data['date_end'] = strtotime($data['date_end']);

			// format checkbox values for database
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
			$data['editors'] = isset($data['editors']) ? 1 : 0;
			$data['admins'] = isset($data['admins']) ? 1 : 0;
	
			$event->update($data);
	
			return Redirect::route('events.show', $id)->with('message', 'Event updated.');
		}
	}

	/**
	 * Remove the specified uvent from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			Uvent::destroy($id);
	
			return Redirect::route('events.index')->with('message', 'Event deleted.');
		}
	}
	
	/**
	 * Remove uvents.
	 */
	public function delete()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			foreach (Input::get('ids') as $id) {
				Uvent::destroy($id);
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('events.index')->with('message', 'Events deleted.');
			}
			else {
				return Redirect::back()->with('message', 'Event deleted.');
			}
		}
	}
	
	/**
	 * Diable uvents.
	 */
	public function disable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			foreach (Input::get('ids') as $id) {
				Uvent::find($id)->update(['disabled' => 1]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('events.index')->with('message', 'Events disabled.');
			}
			else {
				return Redirect::back()->with('message', 'Event disabled.');
			}
		}
	}
	
	/**
	 * Enable uvents.
	 */
	public function enable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			foreach (Input::get('ids') as $id) {
				Uvent::find($id)->update(['disabled' => 0]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('events.index')->with('message', 'Events enabled.');
			}
			else {
				return Redirect::back()->with('message', 'Event enabled.');
			}
		}
	}

}