<?php

class Lead extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'leads';
	protected $fillable = array('first_name','last_name','email','gender','dob','phone','sponsor_id','opportunity_id','disabled');

	public function sponsor() {
		return $this->belongsTo('User', 'sponsor_id', 'id');
	}

	public function opportunity() {
		return $this->belongsTo('Opportunity', 'opportunity_id', 'id');
	}

	public function registrations() {
		return $this->morphMany('Registration', 'registerable');
	}

	public function getFormattedPhoneAttribute($value)
	{
		if (!empty($this->phone)) {
			return substr($this->phone, 0, 3)."-".substr($this->phone, 3, 3)."-".substr($this->phone,6);
		}
	}

	public function getSponsorNameAttribute() {
		return ((isset($this->sponsor->first_name))&&(isset($this->sponsor->first_name)))?$this->sponsor->first_name . ' ' . $this->sponsor->last_name:'';
	}

	public function getOpportunityNameAttribute() {
		return (isset($this->opportunity->title))?$this->opportunity->title:'';
	}

	protected $appends = array('opportunity_name', 'sponsor_name', 'formatted_phone');

}