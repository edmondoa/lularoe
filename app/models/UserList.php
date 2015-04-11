<?php

class UserList extends \Eloquent 
{

    // Add your validation rules here
    public static $rules = [
    // 'title' => 'required'
    ];

    // Don't forget to fill this array    
    protected $table = 'users';
    protected $hidden = [
        'password',
        'hide_billing_address',
        'hide_dob',
        'hide_email',
        'hide_gender',
        'hide_phone',
        'hide_shipping_address',
        'image',
        'key',
        'min_commission',
        'mobile_plan_id',
        'original_sponsor_id',
        'phone_sms',
        'remember_token',
        'subscribed',
        'subscription_notice',
        'verified',
        'password',
        'hasSignUp'
    ];
    

    ##############################################################################################
    # append custom Attribs
    ##############################################################################################
    
    public function getDescendantCountAttribute() {
        return (int) (isset($this->descendantsCountRelation()->count))?$this->descendantsCountRelation()->count:0;
    } 
}