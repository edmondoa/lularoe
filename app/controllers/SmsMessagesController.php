<?php 

class SmsMessagesController extends \BaseController
{
	protected $smsMessages;

	public function __construct(SmsMessages $smsMessages)
	{
		$this->smsMessages = $smsMessages;
	}

	public function index()
	{
    	$smsMessages = $this->smsMessages->all();
        $this->layout->content = \View::make('smsMessages.index', compact('smsMessages'));
	}

	public function create()
	{
        $this->layout->content = \View::make('smsMessages.create');
	}

	public function store()
	{
        $this->smsMessages->store(\Input::only('body'));
        return \Redirect::route('smsMessages.index');
	}

	public function show($id)
	{
        $smsMessages = $this->smsMessages->find($id);
        $this->layout->content = \View::make('smsMessages.show')->with('smsMessages', $smsMessages);
	}

	public function edit($id)
	{
        $smsMessages = $this->smsMessages->find($id);
        $this->layout->content = \View::make('smsMessages.edit')->with('smsMessages', $smsMessages);
	}

	public function update($id)
	{
        $this->smsMessages->find($id)->update(\Input::only('body'));
        return \Redirect::route('smsMessages.show', $id);
	}

	public function destroy($id)
	{
        $this->smsMessages->destroy($id);
        return \Redirect::route('smsMessages.index');
	}

}
