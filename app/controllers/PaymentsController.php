<?php 

class PaymentsController extends \BaseController
{
	protected $payments;

	public function __construct(Payments $payments)
	{
		$this->payments = $payments;
	}

	public function index()
	{
    	$payments = $this->payments->all();
        $this->layout->content = \View::make('payments.index', compact('payments'));
	}

	public function create()
	{
        $this->layout->content = \View::make('payments.create');
	}

	public function store()
	{
        $this->payments->store(\Input::only('user_id','transaction_id','amount','tender','details'));
        return \Redirect::route('payments.index');
	}

	public function show($id)
	{
        $payments = $this->payments->find($id);
        $this->layout->content = \View::make('payments.show')->with('payments', $payments);
	}

	public function edit($id)
	{
        $payments = $this->payments->find($id);
        $this->layout->content = \View::make('payments.edit')->with('payments', $payments);
	}

	public function update($id)
	{
        $this->payments->find($id)->update(\Input::only('user_id','transaction_id','amount','tender','details'));
        return \Redirect::route('payments.show', $id);
	}

	public function destroy($id)
	{
        $this->payments->destroy($id);
        return \Redirect::route('payments.index');
	}

}
