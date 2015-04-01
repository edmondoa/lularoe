<?php

class Receipt extends \Eloquent {

	// Don't forget to fill this array    
	protected $table = 'receipts';
	protected $fillable = ['to_email','to_firstname','to_lastname','data','date_paid','tax','subtotal','user_id'];

	public function ledger() {
		return $this->hasMany('Ledger');
	}
	

}
