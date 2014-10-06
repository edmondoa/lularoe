<?php 

class Profiles extends \Eloquent
{
    protected $table = 'profiles';
	protected $fillable = array('public_name','public_content','receive_company_email','receive_company_sms','receive_upline_email','receive_upline_sms','receive_downline_email');


    public function store($input)
    {
        $profiles = new Profiles;
        
        $profiles->public_name = $input['public_name'];
        
        $profiles->public_content = $input['public_content'];
        
        $profiles->receive_company_email = $input['receive_company_email'];
        
        $profiles->receive_company_sms = $input['receive_company_sms'];
        
        $profiles->receive_upline_email = $input['receive_upline_email'];
        
        $profiles->receive_upline_sms = $input['receive_upline_sms'];
        
        $profiles->receive_downline_email = $input['receive_downline_email'];
        
        $profiles->save();
    }
}