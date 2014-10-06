<?php 

class EmailMessages extends \Eloquent
{
    protected $table = 'email_messages';
	protected $fillable = array('subject','body');


    public function store($input)
    {
        $emailMessages = new EmailMessages;
        
        $emailMessages->subject = $input['subject'];
        
        $emailMessages->body = $input['body'];
        
        $emailMessages->save();
    }
}