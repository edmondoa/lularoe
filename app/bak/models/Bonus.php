<?php

class Bonus extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'bonuses';
	protected $fillable = array('user_id','eight_in_eight','twelve_in_twelve','disabled');


}