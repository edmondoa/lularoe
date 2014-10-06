<?php 

class Sales extends \Eloquent
{
    protected $table = 'sales';
	protected $fillable = array('product_id','user_id','sponsor_id','quantity');


    public function store($input)
    {
        $sales = new Sales;
        
        $sales->product_id = $input['product_id'];
        
        $sales->user_id = $input['user_id'];
        
        $sales->sponsor_id = $input['sponsor_id'];
        
        $sales->quantity = $input['quantity'];
        
        $sales->save();
    }
}