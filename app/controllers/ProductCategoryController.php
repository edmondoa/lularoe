<?php

class productCategoryController extends \BaseController {

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
		$productCategories = ProductCategory::all();
		$selectCategories = [];
		$selectCategories[''] = 'None';
		foreach ($productCategories as $productCategory) {
			// $tab = '';
			$parent = ProductCategory::find($productCategory->parent_id);
			// while ($parent['id'] != 0) {
				// $parent = ProductCategory::find($parent['parent_id']);
				// $tab .= '--';
			// }
			$selectCategories[$productCategory->id] = /*$tab . */$productCategory->name;
		}
		return View::make('productCategory.create', compact('selectCategories'));
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
		
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		
		return Redirect::route('productCategories.index')->with('message', 'Product Category created.');
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

		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));

		return Redirect::route('productCategories.show', $id)->with('message', 'Product Category updated.');
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
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		return Redirect::route('productCategories.index')->with('message', 'Product Category deleted.');
	}
	
	/**
	 * Remove productCategories.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			ProductCategory::destroy($id);
		}
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'Product Categories deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Product Category deleted.');
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
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'Product Categories disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Product Category disabled.');
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
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'Product Categories enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Product Category enabled.');
		}
	}

}