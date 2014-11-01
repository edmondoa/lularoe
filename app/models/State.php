<?php

class State extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'abbr' => 'required|alpha|digits:2',
		'full_name' => 'required|alpha'
	];

	// Don't forget to fill this array
	protected $fillable = ['abbr','full_name'];

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}