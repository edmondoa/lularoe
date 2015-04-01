<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class Ledger extends \Eloquent 
{

/*
	public static $rules = [
		'user_id' => 'required',
	];

	// Don't forget to fill this array
	protected $fillable = [
		'user_id',
		'account',
		'amount',
		'txtype',
		'transactionid',
		'data',
		'tax',
		'created_at'
	];

*/
	// Don't forget to fill this array    
	protected $table = 'ledger';

	public function getLedgerList($id = null) {
		return $this->ledger($id);
	}

	public function receipt() {
		return $this->belongsTo('Receipt','receipt_id');
	}

}
