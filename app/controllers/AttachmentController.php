<?php

class attachmentController extends \BaseController {

	/**
	 * Display a listing of attachments
	 *
	 * @return Response
	 */
	public function index()
	{
		$attachments = Attachment::all();

		return View::make('attachment.index', compact('attachments'));
	}

	/**
	 * Show the form for creating a new attachment
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('attachment.create');
	}

	/**
	 * Store a newly created attachment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Attachment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Attachment::create($data);

		return Redirect::route('attachments.index')->with('message', 'Attachments created.');
	}

	/**
	 * Display the specified attachment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$attachment = Attachment::findOrFail($id);

		return View::make('attachment.show', compact('attachment'));
	}

	/**
	 * Show the form for editing the specified attachment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$attachment = Attachment::find($id);

		return View::make('attachment.edit', compact('attachment'));
	}

	/**
	 * Update the specified attachment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$attachment = Attachment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Attachment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$attachment->update($data);

		return Redirect::route('attachments.show', $id)->with('message', 'Attachments updated.');
	}

	/**
	 * Remove the specified attachment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Attachment::destroy($id);
		//return Redirect::route('attachments.index')->with('message', 'Attachments deleted.');
	}
	
	/**
	 * Remove attachments.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Attachment::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('attachments.index')->with('message', 'Attachments deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Attachments deleted.');
		}
	}
	
	/**
	 * Diable attachments.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Attachment::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('attachments.index')->with('message', 'Attachments disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Attachments disabled.');
		}
	}
	
	/**
	 * Enable attachments.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Attachment::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('attachments.index')->with('message', 'Attachments enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Attachments enabled.');
		}
	}

}