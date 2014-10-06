<?php 

class SmsRecipients extends \Eloquent
{
    protected $table = 'sms_recipients';
	protected $fillable = array('email_message_id','user_id');


    public function store($input)
    {
        $smsRecipients = new SmsRecipients;
        
        $smsRecipients->email_message_id = $input['email_message_id'];
        
        $smsRecipients->user_id = $input['user_id'];
        
        $smsRecipients->save();
    }
}