<?php

class EmailMessage extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'email_messages';
	protected $fillable = array('sender_id','subject','body','messagable_type','messagable_id','disabled');

	public function recipients()
	{
		return $this->hasMany('MessageRecipient', 'recipientable');
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}