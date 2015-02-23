<?php

class Page extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [

	];

	// Don't forget to fill this array    
	protected $table = 'pages';
	protected $fillable = array('title','short_title','url','type','body','public','customers','reps','public_header','public_footer','back_office_header','back_office_footer','template','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}