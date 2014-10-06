<?php 

class EmailMessagesController extends \BaseController
{
	protected $emailMessages;

	public function __construct(EmailMessages $emailMessages)
	{
		$this->emailMessages = $emailMessages;
	}

	public function index()
	{
    	$emailMessages = $this->emailMessages->all();
        $this->layout->content = \View::make('emailMessages.index', compact('emailMessages'));
	}

	public function create()
	{
        $this->layout->content = \View::make('emailMessages.create');
	}

	public function store()
	{
        $this->emailMessages->store(\Input::only('subject','body'));
        return \Redirect::route('emailMessages.index');
	}

	public function show($id)
	{
        $emailMessages = $this->emailMessages->find($id);
        $this->layout->content = \View::make('emailMessages.show')->with('emailMessages', $emailMessages);
	}

	public function edit($id)
	{
        $emailMessages = $this->emailMessages->find($id);
        $this->layout->content = \View::make('emailMessages.edit')->with('emailMessages', $emailMessages);
	}

	public function update($id)
	{
        $this->emailMessages->find($id)->update(\Input::only('subject','body'));
        return \Redirect::route('emailMessages.show', $id);
	}

	public function destroy($id)
	{
        $this->emailMessages->destroy($id);
        return \Redirect::route('emailMessages.index');
	}

}
