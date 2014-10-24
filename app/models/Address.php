<?php 

class Address extends \Eloquent
{
	
	// Add your validation rules here
	public static $rules = [
		'address' => 'required',
		'address2' => 'sometimes',
		'city' => 'required',
		'state' => 'required',
		'zip' => 'required',
		//'address_type' => 'required|in:Billing,Shipping',
	];
	
	protected $table = 'addresses';
	protected $fillable = array('address_1','address_2','city','state','addressable_id','zip','addressable_type','disabled');

	public function addressable()
	{
		return $this->morphTo();
	}


}