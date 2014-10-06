<?php 

class Products extends \Eloquent
{
    protected $table = 'products';
	protected $fillable = array('name','blurb','description','price','quantity');


    public function store($input)
    {
        $products = new Products;
        
        $products->name = $input['name'];
        
        $products->blurb = $input['blurb'];
        
        $products->description = $input['description'];
        
        $products->price = $input['price'];
        
        $products->quantity = $input['quantity'];
        
        $products->save();
    }
}