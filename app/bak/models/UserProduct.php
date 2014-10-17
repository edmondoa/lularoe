<?php

class UserProduct extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'user_products';
	protected $fillable = array('product_id','disabled');


}