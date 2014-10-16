<?php

class Profile extends \Eloquent
{

 // Add your validation rules here
 public static $rules = [
  // 'title' => 'required'
 ];

 // Don't forget to fill this array    
 protected $table = 'profiles';
	protected $fillable = array('public_name','public_content','receive_company_email','receive_company_sms','receive_upline_email','receive_upline_sms','receive_downline_email','receive_downline_sms','disabled');


}