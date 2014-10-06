<?php 

class EmailRecipients extends \Eloquent
{
    protected $table = 'email_recipients';
	protected $fillable = array('sms_message_id','user_id');


    public function store($input)
    {
        $emailRecipients = new EmailRecipients;
        
        $emailRecipients->sms_message_id = $input['sms_message_id'];
        
        $emailRecipients->user_id = $input['user_id'];
        
        $emailRecipients->save();
    }
}