<?php

class Opportunity extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'opportunities';
	protected $fillable = array('title','body','include_form','public','customers','reps','deadline','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}

	public function getFormattedDeadlineDateAttribute($value)
	{
		if ($this->deadline !== 0) return date('m/d/Y',$this->attributes['deadline']);
	}
	
	public function getFormattedDeadlineTimeAttribute($value)
	{
		if ($this->deadline !== 0) return date('g:i A',$this->attributes['deadline']);
	}

	public function getStatusAttribute($value)
	{
		return ($this->attributes['disabled'] == 0) ? 'Active' : 'Disabled';
	}

	protected $appends = array('new_record','formatted_deadline_date','formatted_deadline_time','status');
}
