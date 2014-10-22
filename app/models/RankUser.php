<?php

class RankUser extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'rank_user';
	protected $fillable = array('user_id','rank_id','disabled');


}