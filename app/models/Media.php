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

	public function getUserRoleNameAttribute() {
		return User::find($this->user_id)->role_name;
		exit;
	}

	public function getImageSmAttribute() {
		$image_sm = explode('.', $this->url);
		if (isset($image_sm[1])) return $image_sm[0] . '-sm.' . $image_sm[1];
		else return '';	
	}

	protected $appends = array('new_record', 'owner', 'image_sm', 'user_role_name');


}