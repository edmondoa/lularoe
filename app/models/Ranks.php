<?php 

class Ranks extends \Eloquent
{
    protected $table = 'ranks';
	protected $fillable = array('name');


    public function store($input)
    {
        $ranks = new Ranks;
        
        $ranks->name = $input['name'];
        
        $ranks->save();
    }
}