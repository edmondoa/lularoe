<?php

class productController extends \BaseController {

	/**
	 * Display a listing of products
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::all();
		$categories = ProductCategory::all();
		$tags = ProductTag::all();
		return View::make('product.index', compact('products', 'categories', 'tags'));
	}

	/**
	 * Show the form for creating a new product
	 *
	 * @return Response
	 */
	public function create()
	{
		$productCategories = ProductCategory::all();
		$selectCategories = [];
		foreach ($productCategories as $productCategory) {
			$parent = ProductCategory::find($productCategory->parent_id);
			$selectCategories[$productCategory->id] = /*$tab . */$productCategory->name;
		}
		return View::make('product.create', compact('selectCategories'));
	}

	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Product::$rules);
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// process image
		if ($data['image'] != '' || $data['image_url'] != '') {
			if ($data['image_url'] == '') {
				include app_path() . '/helpers/processMedia.php';
				if (isset($data['url'])) $data['image'] = $data['url'];
			}
			else $data['image'] = $data['image_url'];
		}
		else unset($data['image']);

		$product = Product::create($data);
		
		// store tags
		if (isset($data['tag_names'])) {
			foreach ($data['tag_names'] as $tag_name) {
				$productTag = [];
				$productTag['name'] = $tag_name;
				$productTag['taggable_id'] = $product->id;
				$productTag['product_category_id'] = $data['category_id'];
				ProductTag::create($productTag);
			}
		}
		
		// clear cache
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		return Redirect::route('products.index')->with('message', 'Product created.');
	}

	/**
	 * Display the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::findOrFail($id);

		return View::make('product.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);
		$productCategories = ProductCategory::all();
		$selectCategories = [];
		foreach ($productCategories as $productCategory) {
			$parent = ProductCategory::find($productCategory->parent_id);
			$selectCategories[$productCategory->id] = /*$tab . */$productCategory->name;
		}
		$tags = Product::find($id)->tags;
		return View::make('product.edit', compact('product', 'selectCategories', 'tags'));
	}

	/**
	 * Update the specified product in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = Product::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// process image
		if ($data['image'] != '' || $data['image_url'] != '') {
			if ($data['image_url'] == '') {
				include app_path() . '/helpers/processMedia.php';
				if (isset($data['url'])) $data['image'] = $data['url'];
			}
			else $data['image'] = $data['image_url'];
		}
		else unset($data['image']);

		// store tags
		if (isset($data['tag_names'])) {
			foreach ($data['tag_names'] as $tag_name) {
				$productTag = [];
				$productTag['name'] = $tag_name;
				$productTag['taggable_id'] = $product->id;
				$productTag['product_category_id'] = $data['category_id'];
				ProductTag::create($productTag);
			}
		}

		// save
		$product->update($data);
		// clear cache
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		return Redirect::route('products.show', $id)->with('message', 'Product updated.');
	}

	/**
	 * Remove the specified product from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete images
		$product = Product::find($id);
		unlink('uploads/' . $product->image);
		unlink('uploads/' . $product->image_sm);
		// delete record
		Product::destroy($id);
		// clear cache
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		return Redirect::route('products.index')->with('message', 'Product deleted.');
	}
	
	/**
	 * Remove products.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			// delete images
			$product = Product::find($id);
			unlink('uploads/' . $product->image);
			unlink('uploads/' . $product->image_sm);
			// delete record
			Product::destroy($id);
		}
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('products.index')->with('message', 'Products deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Product deleted.');
		}
	}
	
	/**
	 * Diable products.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Product::find($id)->update(['disabled' => 1]);	
		}
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('products.index')->with('message', 'Products disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Product disabled.');
		}
	}
	
	/**
	 * Enable products.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Product::find($id)->update(['disabled' => 0]);	
		}
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('products.index')->with('message', 'Products enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Product enabled.');
		}
	}

}