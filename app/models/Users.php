<?php 

class Users extends \Eloquent
{
    protected $table = 'users';
	protected $fillable = array('first_name','last_name','email','password','key','code','phone','role_id','sponsor_id','mobile_plan_id','min_commission');


    public function store($input)
    {
        $users = new Users;
        
        $users->first_name = $input['first_name'];
        
        $users->last_name = $input['last_name'];
        
        $users->email = $input['email'];
        
        $users->password = $input['password'];
        
        $users->key = $input['key'];
        
        $users->code = $input['code'];
        
        $users->phone = $input['phone'];
        
        $users->role_id = $input['role_id'];
        
        $users->sponsor_id = $input['sponsor_id'];
        
        $users->mobile_plan_id = $input['mobile_plan_id'];
        
        $users->min_commission = $input['min_commission'];
        
        $users->save();
    }
}