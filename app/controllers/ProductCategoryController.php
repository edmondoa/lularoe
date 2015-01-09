<?php

class productCategoryController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllProductCategories(){
		$productCategories = ProductCategory::all();
		foreach ($productCategories as $productCategory)
		{
			if (strtotime($productCategory['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$productCategory['new'] = 1;
			}
		}
		return $productCategories;
	}

	/**
	 * Display a listing of productCategories
	 *
	 * @return Response
	 */
	public function index()
	{
		$productCategories = ProductCategory::all();

		return View::make('productCategory.index', compact('productCategories'));
	}

	/**
	 * Show the form for creating a new productCategory
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('productCategory.create');
	}

	/**
	 * Store a newly created productCategory in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), ProductCategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		ProductCategory::create($data);

		return Redirect::route('productCategories.index')->with('message', 'ProductCategory created.');
	}

	/**
	 * Display the specified productCategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$productCategory = ProductCategory::findOrFail($id);

		return View::make('productCategory.show', compact('productCategory'));
	}

	/**
	 * Show the form for editing the specified productCategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$productCategory = ProductCategory::find($id);

		return View::make('productCategory.edit', compact('productCategory'));
	}

	/**
	 * Update the specified productCategory in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$productCategory = ProductCategory::findOrFail($id);

		$validator = Validator::make($data = Input::all(), ProductCategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$productCategory->update($data);

		return Redirect::route('productCategories.show', $id)->with('message', 'ProductCategory updated.');
	}

	/**
	 * Remove the specified productCategory from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		ProductCategory::destroy($id);

		return Redirect::route('productCategories.index')->with('message', 'ProductCategory deleted.');
	}
	
	/**
	 * Remove productCategories.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			ProductCategory::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'ProductCategories deleted.');
		}
		else {
			return Redirect::back()->with('message', 'ProductCategory deleted.');
		}
	}
	
	/**
	 * Diable productCategories.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			ProductCategory::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'ProductCategories disabled.');
		}
		else {
			return Redirect::back()->with('message', 'ProductCategory disabled.');
		}
	}
	
	/**
	 * Enable productCategories.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			ProductCategory::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'ProductCategories enabled.');
		}
		else {
			return Redirect::back()->with('message', 'ProductCategory enabled.');
		}
	}

}