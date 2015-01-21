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
	
	public function getFormattedDateAttribute() {
		if ($this->publish_date > 0) $date = $this->publish_date;
		else $date = $this->created_at;
		return date('M d Y', strtotime($date));
	}
	
	protected $appends = array('new_record', 'formatted_date');

}