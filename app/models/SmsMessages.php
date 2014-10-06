<?php 

class SmsMessages extends \Eloquent
{
    protected $table = 'sms_messages';
	protected $fillable = array('body');


    public function store($input)
    {
        $smsMessages = new SmsMessages;
        
        $smsMessages->body = $input['body'];
        
        $smsMessages->save();
    }
}