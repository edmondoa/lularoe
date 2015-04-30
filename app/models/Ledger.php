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
    
    public static function getLedgers($user_id){
        return(Ledger::where('user_id',$user_id)->orderBy('created_at','desc')->get());
    }

	public function receipt() {
		return $this->belongsTo('Receipt','receipt_id');
	}
    
    public static function countLedgerForDate($user_id, $start_date, $end_date){
        $sql = 'select count(*) as num_ledger from ledger where user_id = :user_id and ';
        $sql .= "created_at between :start_date and :end_date";
        return DB::select(
                DB::raw($sql),
                [
                    'user_id' => $user_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );
    }

}
