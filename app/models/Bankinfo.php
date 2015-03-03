<?php

class Bankinfo extends \Eloquent {

	protected $table = 'bankinfo_user';
	protected $fillable = ['bank_name', 'bank_routing', 'bank_account', 'license_state', 'license_number'];

	public function accountholder() {
        return $this->belongsTo('User');
    }

	public function getInfo(){
		print $this->accountholder()->id;
		return($this->bank_name);
	}


}
