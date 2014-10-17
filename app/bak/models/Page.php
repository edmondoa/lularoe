<?php

class Page extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'pages';
	protected $fillable = array('title','url','type','body','disabled');


}