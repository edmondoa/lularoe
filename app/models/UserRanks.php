<?php 

class UserRanks extends \Eloquent
{
    protected $table = 'user_ranks';
	protected $fillable = array('user_id','rank_id');


    public function store($input)
    {
        $userRanks = new UserRanks;
        
        $userRanks->user_id = $input['user_id'];
        
        $userRanks->rank_id = $input['rank_id'];
        
        $userRanks->save();
    }
}