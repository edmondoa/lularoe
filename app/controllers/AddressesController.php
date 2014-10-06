<?php 

class AddressesController extends \BaseController
{
	protected $addresses;

	public function __construct(Addresses $addresses)
	{
		$this->addresses = $addresses;
	}

	public function index()
	{
    	$addresses = $this->addresses->all();
        $this->layout->content = \View::make('addresses.index', compact('addresses'));
	}

	public function create()
	{
        $this->layout->content = \View::make('addresses.create');
	}

	public function store()
	{
        $this->addresses->store(\Input::only('address_1','address_2','city','state','addressable_id','zip'));
        return \Redirect::route('addresses.index');
	}

	public function show($id)
	{
        $addresses = $this->addresses->find($id);
        $this->layout->content = \View::make('addresses.show')->with('addresses', $addresses);
	}

	public function edit($id)
	{
        $addresses = $this->addresses->find($id);
        $this->layout->content = \View::make('addresses.edit')->with('addresses', $addresses);
	}

	public function update($id)
	{
        $this->addresses->find($id)->update(\Input::only('address_1','address_2','city','state','addressable_id','zip'));
        return \Redirect::route('addresses.show', $id);
	}

	public function destroy($id)
	{
        $this->addresses->destroy($id);
        return \Redirect::route('addresses.index');
	}

}
