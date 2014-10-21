<?php

class UserRank extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'user_ranks';
	protected $fillable = array('user_id','rank_id','disabled');


}