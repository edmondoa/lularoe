<?php 

class ProductController extends \BaseController
{
	protected $product;

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
        $this->product->store(\Input::only('name','blurb','description','price','quantity','disabled'));
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
        $this->product->find($id)->update(\Input::only('name','blurb','description','price','quantity','disabled'));
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
	
	public function delete($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->product->destroy($id);
			}
			return \Redirect::route('product.index')->with('message', 'Products deleted.');;
		}
		else {
	        $this->product->destroy($id);
	        return \Redirect::route('product.index')->with('message', 'Product deleted.');;
		}
	}
	
	public function disable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->product->where('id', $id)->update(array('disabled' => 1));
			}
			return \Redirect::route('product.index')->with('message', 'Products disabled.');
		}
		else {
	        $this->product->where('id', $id)->update(array('disabled' => 1));
	        return \Redirect::route('product.index')->with('message', 'Product disabled.');;
		}
	}
	
	public function enable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->product->where('id', $id)->update(array('disabled' => NULL));
			}
			return \Redirect::route('product.index')->with('message', 'Products enabled.');;
		}
		else {
	        $this->product->where('id', $id)->update(array('disabled' => NULL));
	        return \Redirect::route('product.index')->with('message', 'Product enabled.');;
		}
	}
	
}
