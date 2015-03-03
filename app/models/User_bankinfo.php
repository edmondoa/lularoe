<?php

class User_bankinfo extends \Eloquent {
	protected $fillable = [];

	protected $table = 'user_bankinfo';
	protected $fillable = ['bank_name', 'bank_routing', 'bank_account', 'license_state', 'license_number'];

	public function _toString() {
		$last4 = substr($this->bank_account,-5)
		$output['bank_name'] = $this->bank_name;
		$output['bank_routing'] = $this->bank_routing;
		$output['bank_account'] = $last4;
		return(json_encode($last4));
	}

}
