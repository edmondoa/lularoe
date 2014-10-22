<?php

class Image extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'images';
	protected $fillable = array('type','url','disabled');


}