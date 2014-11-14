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

	public function getSponsorNameAttribute() {
		return $this->sponsor->first_name . ' ' . $this->sponsor->last_name;
	}

	public function getOpportunityNameAttribute() {
		if (isset($this->opportunity)) return $this->opportunity->title;
		else return '';
	}

	protected $appends = array('opportunity_name', 'sponsor_name');

}