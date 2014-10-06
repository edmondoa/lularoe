<?php 

class UserProducts extends \Eloquent
{
    protected $table = 'user_products';
	protected $fillable = array('product_id');


    public function store($input)
    {
        $userProducts = new UserProducts;
        
        $userProducts->product_id = $input['product_id'];
        
        $userProducts->save();
    }
}