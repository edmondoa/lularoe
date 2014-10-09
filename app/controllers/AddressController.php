<?php 

class AddressController extends \BaseController
{
	protected $address;

	public function __construct(Address $address)
	{
		$this->address = $address;
	}

	public function index()
	{
    	$addresses = $this->address->all();
        $this->layout->content = \View::make('address.index', compact('addresses'));
	}

	public function create()
	{
        $this->layout->content = \View::make('address.create');
	}

	public function store()
	{
        $this->address->store(\Input::only('address_1','address_2','city','state','addressable_id','zip','disabled'));
        return \Redirect::route('address.index');
	}

	public function show($id)
	{
        $address = $this->address->find($id);
        $this->layout->content = \View::make('address.show')->with('address', $address);
	}

	public function edit($id)
	{
        $address = $this->address->find($id);
        $this->layout->content = \View::make('address.edit')->with('address', $address);
	}

	public function update($id)
	{
        $this->address->find($id)->update(\Input::only('address_1','address_2','city','state','addressable_id','zip','disabled'));
        return \Redirect::route('address.show', $id);
	}

	public function destroy($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->address->destroy($id);
			}
			return \Redirect::route('address.index');
		}
		else {
	        $this->address->destroy($id);
	        return \Redirect::route('address.index');
		}
	}
	
	public function delete($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->address->destroy($id);
			}
			return \Redirect::route('address.index')->with('message', 'Addresses deleted.');;
		}
		else {
	        $this->address->destroy($id);
	        return \Redirect::route('address.index')->with('message', 'Address deleted.');;
		}
	}
	
	public function disable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->address->where('id', $id)->update(array('disabled' => 1));
			}
			return \Redirect::route('address.index')->with('message', 'Addresses disabled.');
		}
		else {
	        $this->address->where('id', $id)->update(array('disabled' => 1));
	        return \Redirect::route('address.index')->with('message', 'Address disabled.');;
		}
	}
	
	public function enable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->address->where('id', $id)->update(array('disabled' => NULL));
			}
			return \Redirect::route('address.index')->with('message', 'Addresses enabled.');;
		}
		else {
	        $this->address->where('id', $id)->update(array('disabled' => NULL));
	        return \Redirect::route('address.index')->with('message', 'Address enabled.');;
		}
	}
	
}
