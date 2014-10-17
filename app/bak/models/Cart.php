<?php

class Cart extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'carts';
	protected $fillable = array('product_id','disabled');


}