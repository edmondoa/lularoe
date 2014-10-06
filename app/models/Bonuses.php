<?php 

class Bonuses extends \Eloquent
{
    protected $table = 'bonuses';
	protected $fillable = array('user_id','eight_in_eight','twelve_in_twelve');


    public function store($input)
    {
        $bonuses = new Bonuses;
        
        $bonuses->user_id = $input['user_id'];
        
        $bonuses->eight_in_eight = $input['eight_in_eight'];
        
        $bonuses->twelve_in_twelve = $input['twelve_in_twelve'];
        
        $bonuses->save();
    }
}