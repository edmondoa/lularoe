<?php

class Attachment extends \Eloquent
{

 // Add your validation rules here
	public static $rules = [
		'image' => 'mimes:jpeg,png,jpg|max:1000',
	];

 // Don't forget to fill this array    
 protected $table = 'attachments';
	protected $fillable = array('type','url','user_id','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');


}