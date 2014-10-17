<?php

class Review extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'reviews';
	protected $fillable = array('product_id','rating','comment','disabled');


}