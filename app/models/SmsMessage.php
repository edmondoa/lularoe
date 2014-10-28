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

	public function recipient()
	{
		return $this->belongsTo('User','recipient_id');
	}

	public function sender()
	{
		return $this->belongsTo('User','sender_id');
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}