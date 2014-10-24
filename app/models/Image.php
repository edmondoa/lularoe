<?php

class Image extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'images';
	protected $fillable = array('type','url','disabled');


	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');


}