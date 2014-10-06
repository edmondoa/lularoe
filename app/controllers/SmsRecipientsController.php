<?php 

class SmsRecipientsController extends \BaseController
{
	protected $smsRecipients;

	public function __construct(SmsRecipients $smsRecipients)
	{
		$this->smsRecipients = $smsRecipients;
	}

	public function index()
	{
    	$smsRecipients = $this->smsRecipients->all();
        $this->layout->content = \View::make('smsRecipients.index', compact('smsRecipients'));
	}

	public function create()
	{
        $this->layout->content = \View::make('smsRecipients.create');
	}

	public function store()
	{
        $this->smsRecipients->store(\Input::only('email_message_id','user_id'));
        return \Redirect::route('smsRecipients.index');
	}

	public function show($id)
	{
        $smsRecipients = $this->smsRecipients->find($id);
        $this->layout->content = \View::make('smsRecipients.show')->with('smsRecipients', $smsRecipients);
	}

	public function edit($id)
	{
        $smsRecipients = $this->smsRecipients->find($id);
        $this->layout->content = \View::make('smsRecipients.edit')->with('smsRecipients', $smsRecipients);
	}

	public function update($id)
	{
        $this->smsRecipients->find($id)->update(\Input::only('email_message_id','user_id'));
        return \Redirect::route('smsRecipients.show', $id);
	}

	public function destroy($id)
	{
        $this->smsRecipients->destroy($id);
        return \Redirect::route('smsRecipients.index');
	}

}
