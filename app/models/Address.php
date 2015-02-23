<?php 

class Address extends \Eloquent
{
	
	// Add your validation rules here
	public static $rules = [
		'address_1' => 'required',
		'address_2' => 'sometimes',
		'city' => 'required',
		'state' => 'required',
		'zip' => 'required',
		//'address_type' => 'required|in:Billing,Shipping',
	];
	
	protected $table = 'addresses';
	protected $fillable = array('address_1','address_2','city','state','addressable_id','zip','addressable_type','label','disabled');

	public function addressable()
	{
		return $this->morphTo();
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}