<?php 

class Cart extends \Eloquent
{
    protected $table = 'carts';
	protected $fillable = array('product_id');


    public function store($input)
    {
        $cart = new Cart;
        
        $cart->product_id = $input['product_id'];
        
        $cart->save();
    }
}