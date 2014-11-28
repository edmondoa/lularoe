<?php

class Payment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'amount' => 'required|numeric',
		'tender' => 'required',
		'transaction_id' => 'required',
		'details' => 'required'
	];

	// Don't forget to fill this array
	//public $timestamps = false;

	protected $fillable = ['transaction_id','tender','amount','details','created_at'];

	public function getAmountNumberAttribute(){
		if(isset($this->amount))
		{
			return (double) $this->amount;
		} 
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	protected $appends = array('amount_number');
}