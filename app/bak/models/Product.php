<?php

class Product extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'products';
	protected $fillable = array('name','blurb','description','price','quantity','category_id','disabled');


}