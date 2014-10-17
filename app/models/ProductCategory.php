<?php

class ProductCategory extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'product_categories';
	protected $fillable = array('name','disabled');


}