<?php 

class ProductCategoryController extends \BaseController
{
	protected $productCategory;

	public function __construct(ProductCategory $productCategory)
	{
		$this->productCategory = $productCategory;
	}

	public function index()
	{
    	$productCategories = $this->productCategory->all();
        $this->layout->content = \View::make('productCategory.index', compact('productCategories'));
	}

	public function create()
	{
        $this->layout->content = \View::make('productCategory.create');
	}

	public function store()
	{
        $this->productCategory->store(\Input::only('name','disabled'));
        return \Redirect::route('productCategory.index');
	}

	public function show($id)
	{
        $productCategory = $this->productCategory->find($id);
        $this->layout->content = \View::make('productCategory.show')->with('productCategory', $productCategory);
	}

	public function edit($id)
	{
        $productCategory = $this->productCategory->find($id);
        $this->layout->content = \View::make('productCategory.edit')->with('productCategory', $productCategory);
	}

	public function update($id)
	{
        $this->productCategory->find($id)->update(\Input::only('name','disabled'));
        return \Redirect::route('productCategory.show', $id);
	}

	public function destroy($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->productCategory->destroy($id);
			}
			return \Redirect::route('productCategory.index');
		}
		else {
	        $this->productCategory->destroy($id);
	        return \Redirect::route('productCategory.index');
		}
	}
	
	public function delete($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->productCategory->destroy($id);
			}
			return \Redirect::route('productCategory.index')->with('message', 'ProductCategories deleted.');;
		}
		else {
	        $this->productCategory->destroy($id);
	        return \Redirect::route('productCategory.index')->with('message', 'ProductCategory deleted.');;
		}
	}
	
	public function disable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->productCategory->where('id', $id)->update(array('disabled' => 1));
			}
			return \Redirect::route('productCategory.index')->with('message', 'ProductCategories disabled.');
		}
		else {
	        $this->productCategory->where('id', $id)->update(array('disabled' => 1));
	        return \Redirect::route('productCategory.index')->with('message', 'ProductCategory disabled.');;
		}
	}
	
	public function enable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->productCategory->where('id', $id)->update(array('disabled' => NULL));
			}
			return \Redirect::route('productCategory.index')->with('message', 'ProductCategories enabled.');;
		}
		else {
	        $this->productCategory->where('id', $id)->update(array('disabled' => NULL));
	        return \Redirect::route('productCategory.index')->with('message', 'ProductCategory enabled.');;
		}
	}
	
}
