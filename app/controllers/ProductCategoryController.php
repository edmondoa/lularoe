<?php

class productCategoryController extends \BaseController {

	/**
<<<<<<< HEAD
=======
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
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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
<<<<<<< HEAD
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
=======
		return View::make('productCategory.create');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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
<<<<<<< HEAD
		
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		
		return Redirect::route('productCategories.index')->with('message', 'Product Category created.');
=======

		return Redirect::route('productCategories.index')->with('message', 'ProductCategory created.');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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

<<<<<<< HEAD
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));

		return Redirect::route('productCategories.show', $id)->with('message', 'Product Category updated.');
=======
		return Redirect::route('productCategories.show', $id)->with('message', 'ProductCategory updated.');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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
<<<<<<< HEAD
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		return Redirect::route('productCategories.index')->with('message', 'Product Category deleted.');
=======

		return Redirect::route('productCategories.index')->with('message', 'ProductCategory deleted.');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
	}
	
	/**
	 * Remove productCategories.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			ProductCategory::destroy($id);
		}
<<<<<<< HEAD
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'Product Categories deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Product Category deleted.');
=======
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'ProductCategories deleted.');
		}
		else {
			return Redirect::back()->with('message', 'ProductCategory deleted.');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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
<<<<<<< HEAD
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'Product Categories disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Product Category disabled.');
=======
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'ProductCategories disabled.');
		}
		else {
			return Redirect::back()->with('message', 'ProductCategory disabled.');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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
<<<<<<< HEAD
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProductCategories')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'Product Categories enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Product Category enabled.');
=======
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('productCategories.index')->with('message', 'ProductCategories enabled.');
		}
		else {
			return Redirect::back()->with('message', 'ProductCategory enabled.');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
		}
	}

}