<?php

class Commissionline extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['amount','description','commission_period'];

	public function user() {
		return $this->belongsTo('User');
	}
	
	public function source() {
		return $this->belongsTo('User','source_id');
	}
	
}