<?php 

class ProductController extends \BaseController
{
	protected $product;
	
	// data only
	public function getAllProducts(){
		return Product::all();
	}

	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	public function index()
	{
    	$products = $this->product->all();
        $this->layout->content = \View::make('product.index', compact('products'));
	}

	public function create()
	{
        $this->layout->content = \View::make('product.create');
	}

	public function store()
	{
        $this->product->store(\Input::only('name','blurb','description','price','quantity','category_id','disabled'));
        return \Redirect::route('product.index');
	}

	public function show($id)
	{
        $product = $this->product->find($id);
        $this->layout->content = \View::make('product.show')->with('product', $product);
	}

	public function edit($id)
	{
        $product = $this->product->find($id);
        $this->layout->content = \View::make('product.edit')->with('product', $product);
	}

	public function update($id)
	{
        $this->product->find($id)->update(\Input::only('name','blurb','description','price','quantity','category_id','disabled'));
        return \Redirect::route('product.show', $id);
	}

	public function destroy($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->product->destroy($id);
			}
			return \Redirect::route('product.index');
		}
		else {
	        $this->product->destroy($id);
	        return \Redirect::route('product.index');
		}
	}
		
	public function disable($id)
	{
		//if ($id == 0) {
			// echo '<pre>'; print_r(Input::only('ids')); echo '</pre>';
			// exit;
			foreach (Input::get('ids') as $id) {
				Product::find($id)->update(['disabled' => 1]);	
				//echo $id;
				// exit;
				//DB::update('update products set disabled = 1 where id = ' . $id . '');
				// $this->product->where('id', $id)->update(['disabled' => 1]);
			}
			return \Redirect::route('product.index')->with('message', 'Products disabled.');
		// }
		// else {
	        // $this->product->where('id', $id)->update(array('disabled' => 1));
	        // return \Redirect::route('product.index')->with('message', 'Product disabled.');;
		// }
	}
	
	public function enable($id)
	{
		// echo '<pre>'; print_r(Input::all()); echo '</pre>';
		// exit;
		//if ($id == 0) {
			foreach (Input::get('ids') as $id) {
				// echo $id[0];
				// exit;
				// DB::update('update products set disabled = 0 where id = ?', array($id));
				// $this->product->where('id', '=', $id)->update(['disabled' => 0]);
				Product::find($id)->update(['disabled' => 0]);
				// $product->disabled = 0;
				// $product->save();
				// echo '<pre>'; print_r($product); echo '</pre>';
			}
			// exit;
			
			return \Redirect::route('product.index')->with('message', 'Products enabled.');;
		// }
		// else {
	        // $this->product->where('id', $id)->update(array('disabled' => NULL));
	        // return \Redirect::route('product.index')->with('message', 'Product enabled.');;
		// }
	}
	
}
