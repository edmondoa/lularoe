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
	protected $fillable = ['transaction_id','tender','amount','details'];

	public function user()
	{
		return $this->belongsTo('User');
	}


}