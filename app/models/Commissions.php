<?php 

class Commissions extends \Eloquent
{
    protected $table = 'commissions';
	protected $fillable = array('user_id','amount','description');


    public function store($input)
    {
        $commissions = new Commissions;
        
        $commissions->user_id = $input['user_id'];
        
        $commissions->amount = $input['amount'];
        
        $commissions->description = $input['description'];
        
        $commissions->save();
    }
}