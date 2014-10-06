<?php 

class Levels extends \Eloquent
{
    protected $table = 'levels';
	protected $fillable = array('user_id','ancestor_id','level');


    public function store($input)
    {
        $levels = new Levels;
        
        $levels->user_id = $input['user_id'];
        
        $levels->ancestor_id = $input['ancestor_id'];
        
        $levels->level = $input['level'];
        
        $levels->save();
    }
}