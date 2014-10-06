<?php 

class EmailRecipientsController extends \BaseController
{
	protected $emailRecipients;

	public function __construct(EmailRecipients $emailRecipients)
	{
		$this->emailRecipients = $emailRecipients;
	}

	public function index()
	{
    	$emailRecipients = $this->emailRecipients->all();
        $this->layout->content = \View::make('emailRecipients.index', compact('emailRecipients'));
	}

	public function create()
	{
        $this->layout->content = \View::make('emailRecipients.create');
	}

	public function store()
	{
        $this->emailRecipients->store(\Input::only('sms_message_id','user_id'));
        return \Redirect::route('emailRecipients.index');
	}

	public function show($id)
	{
        $emailRecipients = $this->emailRecipients->find($id);
        $this->layout->content = \View::make('emailRecipients.show')->with('emailRecipients', $emailRecipients);
	}

	public function edit($id)
	{
        $emailRecipients = $this->emailRecipients->find($id);
        $this->layout->content = \View::make('emailRecipients.edit')->with('emailRecipients', $emailRecipients);
	}

	public function update($id)
	{
        $this->emailRecipients->find($id)->update(\Input::only('sms_message_id','user_id'));
        return \Redirect::route('emailRecipients.show', $id);
	}

	public function destroy($id)
	{
        $this->emailRecipients->destroy($id);
        return \Redirect::route('emailRecipients.index');
	}

}
