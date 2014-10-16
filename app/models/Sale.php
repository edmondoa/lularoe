<?php

class Sale extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'sales';
	protected $fillable = array('product_id','user_id','sponsor_id','quantity','disabled');


}