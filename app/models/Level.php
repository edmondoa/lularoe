<?php

class Level extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'levels';
	protected $fillable = array('user_id','ancestor_id','level','disabled');


}