<?php

class Media extends \Eloquent
{

 // Don't forget to fill this array    
 protected $table = 'media';
 
	protected $fillable = array('type','url','user_id','title','description','reps','disabled');
 
	public function getOwnerAttribute() {
		return User::find($this->user_id)->full_name;
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record', 'owner');


}