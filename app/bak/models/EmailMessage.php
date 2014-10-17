<?php

class EmailMessage extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'email_messages';
	protected $fillable = array('sender_id','recipient_id','subject','body','disabled');


}