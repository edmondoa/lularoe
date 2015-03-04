<?php

class Bankinfo extends \Eloquent {

	protected $table = 'bankinfo_user';
	protected $fillable = ['user_id','bank_name', 'bank_routing', 'bank_account', 'license_state', 'license_number'];
   public static $rules = [
        'bank_name' => 'required',
        'bank_routing' => 'required|numeric',
        'bank_account' => 'required|numeric'
    ];
 
	public function accountholder() {
        return $this->belongsTo('User');
    }

	public function getInfo(){
		print $this->accountholder()->id;
		return($this->bank_name);
	}


}
