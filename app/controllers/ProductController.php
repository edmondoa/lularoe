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
	 * Display a listing of public products
	 *
	 * @return Response
	 */
	public function publicIndex()
	{
		$products = Product::all();
		$categories = ProductCategory::all();
		$tags = ProductTag::all();
		return View::make('product.public_index', compact('products', 'categories', 'tags'));
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

		// Also check if this user is superadmin just in case
		$data['user_id'] = Input::get('user_id', Auth::user()->id);

		$product = Product::create($data);

		// store product images
		if (isset($data['images'])) {
			foreach($data['images'] as $key => $image) {
				$image['featured'] = isset($image['featured']) ? 1 : 0;
				$image['path'] = explode('/uploads/', $image['path']);
				$image['path'] = $image['path'][1];
				$media = Media::where('url', $image['path'])->get()->first();
				$attachment = Attachment::create([
					'attachable_type' => 'Product',
					'attachable_id' => $product->id,
					'media_id' => $media->id,
					'featured' => $image['featured'],
				]);
			}
		}

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

		// get product
		$product = Product::findOrFail($id);
		
		// get product images
		$attachment_images = [];
		$attachments = Attachment::where('attachable_type', 'Product')->where('attachable_id', $product->id)->get();
		foreach ($attachments as $attachment) {
			$image = Media::find($attachment->media_id);
			// die($attachment->media_id);
			if ($attachment->featured == 1) $product->featured_image = $image;
			$image_sm = explode('.', $image->url);
			if (isset($image_sm[1])) $image_sm = $image_sm[0] . '-sm.' . $image_sm[1];
			else $image_sm = '';
			$attachment_images[] = $image_sm;
		}
		
		// get product tags
		$tags = Product::find($id)->tags;
		
		// determine whether to show the public or back office view if an extra parameter has been concatenated to $id
		if (strpos($id,'-') !== false) {
			$string = explode('-', $id);
			$id = $string[0];
			$public = $string[1];
		}
		if (isset($public)) $view = 'product.public_show';
		else $view = 'product.show';
		
		// get party organizer if applicable
		if (Session::get('party_id') != null) {
			$organizer = User::find(Session::get('organizer_id'));
		}
		
		return View::make($view, compact('product', 'attachment_images', 'tags', 'organizer'));
	}

	/**
	 * Display the public view for the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function publicShow($id)
	{
		return $this->show($id . '-' . 'public');
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
		
		// get product images
		$attachment_images = [];
		$image_attachments = Attachment::where('attachable_type', 'Product')->where('attachable_id', $product->id)->orderBy('id', 'desc')->get();
		foreach ($image_attachments as $image_attachment) {
			$media = Media::find($image_attachment->media_id);
			$media->featured = $image_attachment->featured;
			$media->attachment_id = $image_attachment->id;
			$attachment_images[] = $media;
		}
		if (count($attachment_images) > 0) {
			$attachment_images_count = end($attachment_images);
			$attachment_images_count = $attachment_images_count->id;
		}
		else $attachment_images_count = 0;

		return View::make('product.edit', compact('product', 'selectCategories', 'tags', 'attachment_images', 'attachment_images_count'));
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

		// store/update product images
		if (isset($data['images'])) {
			foreach($data['images'] as $key => $image) {
				
				// new images
				if (isset($image['new_attachment_image'])) {
					$image['featured'] = isset($image['featured']) ? 1 : 0;
					$image['path'] = explode('/uploads/', $image['path']);
					if (isset($image['path'][1])) $image['path'] = $image['path'][1];
					$media = Media::where('url', $image['path'])->get()->first();
					$attachment = Attachment::create([
						'attachable_type' => 'Product',
						'attachable_id' => $product->id,
						'media_id' => $media->id,
						'featured' => $image['featured'],
					]);
				}
				
				// update existing images
				else {
					$image['featured'] = isset($image['featured']) ? 1 : 0;
					$attachment = Attachment::find($image['attachment_id']);
					$attachment->update([
						'featured' => $image['featured'],
					]);
				}
				
			}
		}

		// save
		$product->update($data);
		// clear cache
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllProducts')));
		return Redirect::route('products.index', $id)->with('message', 'Product updated.');
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
		if (is_file('uploads/' . $product->image)) unlink('uploads/' . $product->image);
		if (is_file('uploads/' . $product->image_sm)) unlink('uploads/' . $product->image_sm);

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
			if (is_file('uploads/' . $product->image)) unlink('uploads/' . $product->image);
			if (is_file('uploads/' . $product->image_sm)) unlink('uploads/' . $product->image_sm);
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
