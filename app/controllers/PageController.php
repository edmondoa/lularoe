<?php

class PageController extends \BaseController {

	/**
	 * Display a listing of pages
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$pages = Page::all();
			return View::make('page.index', compact('pages'));
		}
	}

	/**
	 * Show the form for creating a new page
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return View::make('page.create');
		}
	}

	/**
	 * Store a newly created page in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			// validation
			$rules = [
				'title' => 'required',
				'short_title' => 'required',
				'url' => 'unique|required|alpha_dash',		
				'url' => 'required|alpha_dash|unique:pages'
			];
			$validator = Validator::make($data = Input::all(), Page::$rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
			// format checkbox values for database
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
			if ($data['public'] == 0 && $data['customers'] == 0 && $data['public'] == 0) $data['public'] = 1;
			if ($data['customers'] == 1 || $data['reps'] == 1) $data['public'] = 0;
			$data['public_header'] = isset($data['public_header']) ? 1 : 0;
			$data['public_footer'] = isset($data['public_footer']) ? 1 : 0;
			$data['back_office_header'] = isset($data['back_office_header']) ? 1 : 0;
			$data['back_office_footer'] = isset($data['back_office_footer']) ? 1 : 0;
			
			$page = Page::create($data);
			return Redirect::route('pages.edit', $page->id)->with('message', 'Page created.');
		}
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
		if ($page->public) {
			return View::make('page.show', compact('page', 'title'));
		}
		elseif (Auth::check()) {
			if ($page->public || Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || (Auth::user()->hasRole(['Rep']) && $page->reps) || (Auth::user()->hasRole(['Customer']) && $page->customers)) {
				return View::make('page.show', compact('page', 'title'));
			}
		}
		else return "You don't have permission to view this page.";
	}

	/**
	 * Show the form for editing the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$page = Page::find($id);
			if ($page['customers'] || $page['reps']) $only_show_to = 'checked';
			else $only_show_to = '';
			return View::make('page.edit', compact('page', 'only_show_to'));
		}
	}

	/**
	 * Update the specified page in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$page = Page::findOrFail($id);
			
			// validation
			$rules = [
				'title' => 'required',
				'short_title' => 'required',
				'url' => 'unique|required|alpha_dash',		
				'url' => 'required|alpha_dash|unique:pages,url,' . $page->id
			];
			$validator = Validator::make($data = Input::all(), Page::$rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
	
			strtolower($data['url']);
			
			// format checkbox values for database
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
			if ($data['public'] == 0 && $data['customers'] == 0 && $data['public'] == 0) $data['public'] = 1;
			if ($data['customers'] == 1 || $data['reps'] == 1) $data['public'] = 0;
			$data['public_header'] = isset($data['public_header']) ? 1 : 0;
			$data['public_footer'] = isset($data['public_footer']) ? 1 : 0;
			$data['back_office_header'] = isset($data['back_office_header']) ? 1 : 0;
			$data['back_office_footer'] = isset($data['back_office_footer']) ? 1 : 0;
			
			$page->update($data);
	
			return Redirect::back()->with('message', 'Page updated.');
		}
	}

	/**
	 * Remove the specified page from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			Page::destroy($id);
	
			return Redirect::route('pages.index')->with('message', 'Page deleted.');
		}
	}
	
	/**
	 * Remove pages.
	 */
	public function delete()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
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
	}
	
	/**
	 * Diable pages.
	 */
	public function disable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
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
	}
	
	/**
	 * Enable pages.
	 */
	public function enable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
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

}