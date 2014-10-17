<?php

class emailMessageController extends \BaseController {

	// data only
	public function getAllEmailMessages(){
		return EmailMessage::all();
	}

	/**
	 * Display a listing of emailMessages
	 *
	 * @return Response
	 */
	public function index()
	{
		$emailMessages = EmailMessage::all();

		return View::make('emailMessage.index', compact('emailMessages'));
	}

	/**
	 * Show the form for creating a new emailMessage
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('emailMessage.create');
	}

	/**
	 * Store a newly created emailMessage in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), EmailMessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		EmailMessage::create($data);

		return Redirect::route('emailMessage.index')->with('message', 'EmailMessage created.');
	}

	/**
	 * Display the specified emailMessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$emailMessage = EmailMessage::findOrFail($id);

		return View::make('emailMessage.show', compact('emailMessage'));
	}

	/**
	 * Show the form for editing the specified emailMessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$emailMessage = EmailMessage::find($id);

		return View::make('emailMessage.edit', compact('emailMessage'));
	}

	/**
	 * Update the specified emailMessage in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$emailMessage = EmailMessage::findOrFail($id);

		$validator = Validator::make($data = Input::all(), EmailMessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$emailMessage->update($data);

		return Redirect::route('emailMessages.show')->with('message', 'EmailMessage updated.');
	}

	/**
	 * Remove the specified emailMessage from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		EmailMessage::destroy($id);

		return Redirect::route('emailMessage.index')->with('message', 'EmailMessage deleted.');
	}
	
	/**
	 * Remove emailMessages.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			EmailMessage::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'EmailMessages deleted.');
		}
		else {
			return Redirect::back()->with('message', 'EmailMessage deleted.');
		}
	}
	
	/**
	 * Diable emailMessages.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			EmailMessage::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'EmailMessages disabled.');
		}
		else {
			return Redirect::back()->with('message', 'EmailMessage disabled.');
		}
	}
	
	/**
	 * Enable emailMessages.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			EmailMessage::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'EmailMessages enabled.');
		}
		else {
			return Redirect::back()->with('message', 'EmailMessage enabled.');
		}
	}

}