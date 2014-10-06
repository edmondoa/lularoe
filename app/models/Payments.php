<?php 

class Payments extends \Eloquent
{
    protected $table = 'payments';
	protected $fillable = array('user_id','transaction_id','amount','tender','details');


    public function store($input)
    {
        $payments = new Payments;
        
        $payments->user_id = $input['user_id'];
        
        $payments->transaction_id = $input['transaction_id'];
        
        $payments->amount = $input['amount'];
        
        $payments->tender = $input['tender'];
        
        $payments->details = $input['details'];
        
        $payments->save();
    }
}