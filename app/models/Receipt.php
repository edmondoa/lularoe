<?php

class Receipt extends \Eloquent {

	// Don't forget to fill this array    
	protected $table = 'receipts';
	protected $fillable = ['to_email','to_firstname','to_lastname','data','date_paid','tax','subtotal','user_id'];

	public static function getReceipts($user_id) {
		return(Receipt::where('user_id',$user_id)->orderBy('created_at','desc')->get());
	}

	public function ledger() {
		return $this->hasMany('Ledger');
	}

    public function address() {
        return $this->belongsTo('Address');
    }

    public function receipt() {
        return $this->belongsTo('User');
    }

}
