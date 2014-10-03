<?php 

class Users extends \Eloquent
{
    protected $table = 'users';
	protected $fillable = array('first','last','email','password');


    public function store($input)
    {
        $users = new Users;
        
        $users->first = $input['first'];
        
        $users->last = $input['last'];
        
        $users->email = $input['email'];
        
        $users->password = $input['password'];
        
        $users->save();
    }
}