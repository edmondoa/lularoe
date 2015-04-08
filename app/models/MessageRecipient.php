<?php

class MessageRecipient extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'message_recipients';
	protected $fillable = array('messagable_type','messagable_id','recipientable_type','recipientable_id');

}