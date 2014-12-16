<?php

class Uvent extends \Eloquent
{

	 // Add your validation rules here
	 public static $rules = [
		'name' => 'required',
		'date_start' => 'required|date',
		'date_end' => 'required|date',
		'description' => 'required',
		'timezone' => 'required'
	 ];


 	// Don't forget to fill this array
	protected $table = 'uvents';
	protected $fillable = array('name','description','date_start','date_end','public','customers','reps','editors','admins','disabled','formatted_start_date','formatted_end_date','formatted_start_time','formatted_end_time','timezone');

	public function getLocalStartDateAttribute($value)
	{
		$updated_time = $this->attributes['date_start'];
		$start_date_stamp =	date('Y-m-d G:i:s', $updated_time);
		return Timezone::convertFromUTC($start_date_stamp, $this->attributes['timezone'], 'F j, Y');
	}
	
	public function getLocalStartTimeAttribute($value)
	{
		$updated_time = $this->attributes['date_start'];
		$start_date_stamp =	date('Y-m-d G:i:s', $updated_time);
		return Timezone::convertFromUTC($start_date_stamp, Session::get('timezone'), 'g:i A');
	}

	public function getFormattedStartDateAttribute($value)
	{
		return date('m/d/Y',$this->attributes['date_start']);
	}
	
	public function getFormattedEndDateAttribute($value)
	{
		return date('m/d/Y',$this->attributes['date_end']);
	}
	
	public function getLocalEndDateAttribute($value)
	{
		$updated_time = $this->attributes['date_end'];
		$end_date_stamp = date('Y-m-d G:i:s', $updated_time);
		return Timezone::convertFromUTC($end_date_stamp, $this->attributes['timezone'], 'F j, Y');
	}

	public function getLocalEndTimeAttribute($value)
	{
		$updated_time = $this->attributes['date_end'];
		$end_date_stamp = date('Y-m-d G:i:s', $updated_time);
		return Timezone::convertFromUTC($end_date_stamp, Session::get('timezone'), 'g:i A');
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

	protected $appends = array('new_record','formatted_start_date','formatted_end_date','formatted_start_time','formatted_end_time', 'local_start_date', 'local_start_time', 'local_end_date', 'local_end_time', 'status');

}