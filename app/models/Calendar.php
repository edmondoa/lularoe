<?php

class Calendar extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'calendars';
	protected $fillable = array('name','description','date','public','customers','reps','editors','admins','disabled');


}