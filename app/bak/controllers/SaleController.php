<?php

class saleController extends \BaseController {

	// data only
	public function getAllSales(){
		return Sale::all();
	}

	/**
	 * Display a listing of sales
	 *
	 * @return Response
	 */
	public function index()
	{
		$sales = Sale::all();

		return View::make('sale.index', compact('sales'));
	}

	/**
	 * Show the form for creating a new sale
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sale.create');
	}

	/**
	 * Store a newly created sale in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Sale::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Sale::create($data);

		return Redirect::route('sale.index')->with('message', 'Sale created.');
	}

	/**
	 * Display the specified sale.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sale = Sale::findOrFail($id);

		return View::make('sale.show', compact('sale'));
	}

	/**
	 * Show the form for editing the specified sale.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sale = Sale::find($id);

		return View::make('sale.edit', compact('sale'));
	}

	/**
	 * Update the specified sale in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sale = Sale::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Sale::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$sale->update($data);

		return Redirect::route('sales.show')->with('message', 'Sale updated.');
	}

	/**
	 * Remove the specified sale from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Sale::destroy($id);

		return Redirect::route('sale.index')->with('message', 'Sale deleted.');
	}
	
	/**
	 * Remove sales.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Sale::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('sale.index')->with('message', 'Sales deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Sale deleted.');
		}
	}
	
	/**
	 * Diable sales.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Sale::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('sale.index')->with('message', 'Sales disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Sale disabled.');
		}
	}
	
	/**
	 * Enable sales.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Sale::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('sale.index')->with('message', 'Sales enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Sale enabled.');
		}
	}

}