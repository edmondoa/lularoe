<?php

class SiteConfigController extends \BaseController {

	/**
	 * Display a listing of site_configs
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('site-config.index');
	}

	/**
	 * Show the form for creating a new site_config
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('site-config.create');
	}

	/**
	 * Store a newly created site_config in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), SiteConfig::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		SiteConfig::create($data);
		Cache::forget('site_configs');
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllConfig')));
		return Redirect::action('SiteConfigController@index');
	}

	/**
	 * Display the specified site_config.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$site_config = SiteConfig::findOrFail($id);

		return View::make('site-config.show', compact('site_config'));
	}

	/**
	 * Show the form for editing the specified site_config.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$site_config = SiteConfig::find($id);

		return View::make('site-config.edit', compact('site_config'));
	}

	/**
	 * Update the specified site_config in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$site_config = SiteConfig::findOrFail($id);

		$validator = Validator::make($data = Input::all(), SiteConfig::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$site_config->update($data);
		Cache::forget('site_configs');
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllConfig')));
		return Redirect::action('SiteConfigController@index');
	}

	/**
	 * Remove the specified site_config from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		SiteConfig::destroy($id);

		return Redirect::action('SiteConfigController@index');
	}

}
