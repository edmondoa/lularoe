<?php

class smsMessageController extends \BaseController {

	// data only
	public function getAllSmsMessages(){
		return SmsMessage::all();
	}

	/**
	 * Display a listing of smsMessages
	 *
	 * @return Response
	 */
	public function index()
	{
		$smsMessages = SmsMessage::all();

		return View::make('smsMessage.index', compact('smsMessages'));
	}

	/**
	 * Show the form for creating a new smsMessage
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('smsMessage.create');
	}

	/**
	 * Store a newly created smsMessage in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), SmsMessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		SmsMessage::create($data);

		return Redirect::route('smsMessage.index')->with('message', 'SmsMessage created.');
	}

	/**
	 * Display the specified smsMessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$smsMessage = SmsMessage::findOrFail($id);

		return View::make('smsMessage.show', compact('smsMessage'));
	}

	/**
	 * Show the form for editing the specified smsMessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$smsMessage = SmsMessage::find($id);

		return View::make('smsMessage.edit', compact('smsMessage'));
	}

	/**
	 * Update the specified smsMessage in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$smsMessage = SmsMessage::findOrFail($id);

		$validator = Validator::make($data = Input::all(), SmsMessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$smsMessage->update($data);

		return Redirect::route('smsMessages.show')->with('message', 'SmsMessage updated.');
	}

	/**
	 * Remove the specified smsMessage from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		SmsMessage::destroy($id);

		return Redirect::route('smsMessage.index')->with('message', 'SmsMessage deleted.');
	}
	
	/**
	 * Remove smsMessages.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			SmsMessage::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('smsMessage.index')->with('message', 'SmsMessages deleted.');
		}
		else {
			return Redirect::back()->with('message', 'SmsMessage deleted.');
		}
	}
	
	/**
	 * Diable smsMessages.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			SmsMessage::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('smsMessage.index')->with('message', 'SmsMessages disabled.');
		}
		else {
			return Redirect::back()->with('message', 'SmsMessage disabled.');
		}
	}
	
	/**
	 * Enable smsMessages.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			SmsMessage::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('smsMessage.index')->with('message', 'SmsMessages enabled.');
		}
		else {
			return Redirect::back()->with('message', 'SmsMessage enabled.');
		}
	}

}