<?php

class Media extends \Eloquent
{

 // Don't forget to fill this array    
 protected $table = 'media';
 
	protected $fillable = array('type','url','user_id','title','description','reps','disabled');

	public function tags()
	{
		return $this->morphMany('Tag', 'taggable');
	}
 
	public function getOwnerAttribute() {
		$user = User::find($this->user_id);
		return $user->full_name;
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}

	public function getImageSmAttribute() {
		$image_sm = explode('.', $this->url);
		if (isset($image_sm[1])) return $image_sm[0] . '-sm.' . $image_sm[1];
		else return '';	
	}

	protected $appends = array('new_record', 'owner', 'image_sm');


}