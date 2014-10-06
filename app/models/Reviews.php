<?php 

class Reviews extends \Eloquent
{
    protected $table = 'reviews';
	protected $fillable = array('product_id','rating','comment');


    public function store($input)
    {
        $reviews = new Reviews;
        
        $reviews->product_id = $input['product_id'];
        
        $reviews->rating = $input['rating'];
        
        $reviews->comment = $input['comment'];
        
        $reviews->save();
    }
}