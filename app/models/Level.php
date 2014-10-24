<?php

class Level extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'levels';
	protected $fillable = array('user_id','ancestor_id','level','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');


}