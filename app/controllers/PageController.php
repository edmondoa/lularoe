<?php

class pageController extends \BaseController {

	/**
	 * Display a listing of pages
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = Page::all();

		return View::make('page.index', compact('pages'));
	}

	/**
	 * Show the form for creating a new page
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('page.create');
	}

	/**
	 * Store a newly created page in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Page::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		strtolower($data['url']);
		$page = Page::create($data);
		return Redirect::route('pages.edit', $page->id)->with('message', 'Page created.');

	}

	/**
	 * Display the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($url)
	{
		$page = Page::where('url', $url)->first();
		$title = $page->title;
		return View::make('page.show', compact('page', 'title'));
	}

	/**
	 * Show the form for editing the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = Page::find($id);

		return View::make('page.edit', compact('page'));
	}

	/**
	 * Update the specified page in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$page = Page::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Page::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		strtolower($data['url']);
		$page->update($data);

		return Redirect::back()->with('message', 'Page updated.');
	}

	/**
	 * Remove the specified page from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Page::destroy($id);

		return Redirect::route('pages.index')->with('message', 'Page deleted.');
	}
	
	/**
	 * Remove pages.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Page::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('pages.index')->with('message', 'Pages deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Page deleted.');
		}
	}
	
	/**
	 * Diable pages.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Page::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('pages.index')->with('message', 'Pages disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Page disabled.');
		}
	}
	
	/**
	 * Enable pages.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Page::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('pages.index')->with('message', 'Pages enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Page enabled.');
		}
	}

}