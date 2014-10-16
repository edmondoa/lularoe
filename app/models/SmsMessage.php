<?php

class SmsMessage extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'sms_messages';
	protected $fillable = array('sender_id','recipient_id','body','disabled');


}