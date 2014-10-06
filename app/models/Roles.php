<?php 

class Roles extends \Eloquent
{
    protected $table = 'roles';
	protected $fillable = array('name');


    public function store($input)
    {
        $roles = new Roles;
        
        $roles->name = $input['name'];
        
        $roles->save();
    }
}