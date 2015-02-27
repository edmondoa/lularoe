<?php

class Userstat extends \Eloquent {
	
	protected $fillable = ['first_level_volume','business_volume','commission_period','user_id'];

	public function user() {
		return $this->belongsTo('User');
	}


}