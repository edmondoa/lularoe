<?php 

class UserTest extends \Eloquent
{
    protected $table = 'user_tests';
	protected $fillable = array('first_name','last_name','email','password','gender','key','code','dob','phone','role_id','sponsor_id','mobile_plan_id','min_commission','disabled');


    public function store($input)
    {
        $userTest = new UserTest;
        
        $userTest->first_name = $input['first_name'];
        
        $userTest->last_name = $input['last_name'];
        
        $userTest->email = $input['email'];
        
        $userTest->password = $input['password'];
        
        $userTest->gender = $input['gender'];
        
        $userTest->key = $input['key'];
        
        $userTest->code = $input['code'];
        
        $userTest->dob = $input['dob'];
        
        $userTest->phone = $input['phone'];
        
        $userTest->role_id = $input['role_id'];
        
        $userTest->sponsor_id = $input['sponsor_id'];
        
        $userTest->mobile_plan_id = $input['mobile_plan_id'];
        
        $userTest->min_commission = $input['min_commission'];
        
        $userTest->disabled = $input['disabled'];
        
        $userTest->save();
    }
}