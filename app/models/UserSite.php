<?php

class UserSite extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'user_sites';
	protected $fillable = array('user_id','body');


}