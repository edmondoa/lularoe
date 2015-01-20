<?php

class Post extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [

	];

	// Don't forget to fill this array    
	protected $table = 'posts';
	protected $fillable = array('title','url','description','body','publish_date','postCategory_id','public','customers','reps','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}