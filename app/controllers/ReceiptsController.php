<?php

class ReceiptsController extends \BaseController {

	/**
	 * Display a listing of receipts
	 *
	 * @return Response
	 */
	public function index()
	{
		$receipts = Receipt::all();

		return View::make('receipts.index', compact('receipts'));
	}

	/**
	 * Show the form for creating a new receipt
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('receipts.create');
	}

	/**
	 * Store a newly created receipt in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Receipt::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Receipt::create($data);

		return Redirect::route('receipts.index');
	}

	/**
	 * Display the specified receipt.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$receipt = Receipt::findOrFail($id);

		return View::make('receipts.show', compact('receipt'));
	}

	/**
	 * Show the form for editing the specified receipt.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$receipt = Receipt::find($id);

		return View::make('receipts.edit', compact('receipt'));
	}

	/**
	 * Update the specified receipt in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$receipt = Receipt::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Receipt::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$receipt->update($data);

		return Redirect::route('receipts.index');
	}

	/**
	 * Remove the specified receipt from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Receipt::destroy($id);

		return Redirect::route('receipts.index');
	}

}
