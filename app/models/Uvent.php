<?php

class Uvent extends \Eloquent
{

	 // Add your validation rules here
	 public static $rules = [
		'name' => 'required',
		'date_start' => 'required|date',
		'date_end' => 'required|date',
		'description' => 'required',
	 ];


 	// Don't forget to fill this array
	protected $table = 'uvents';
	protected $fillable = array('name','description','date_start','date_end','public','customers','reps','editors','admins','disabled','formatted_start_date','formatted_end_date','formatted_start_time','formatted_end_time');


	public function getFormattedStartDateAttribute($value)
	{
		return date('m/d/Y',$this->attributes['date_start']);
	}
	
	public function getFormattedEndDateAttribute($value)
	{
		return date('m/d/Y',$this->attributes['date_end']);
	}
	
	public function getFormattedStartTimeAttribute($value)
	{
		return date('g:i A',$this->attributes['date_start']);
	}
	
	public function getFormattedEndTimeAttribute($value)
	{
		return date('g:i A',$this->attributes['date_end']);
	}
	
	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	public function getStatusAttribute($value)
	{
		return ($this->attributes['disabled'] == 0) ? 'Active' : 'Disabled';
	}

	protected $appends = array('new_record','formatted_start_date','formatted_end_date','formatted_start_time','formatted_end_time','status');

}