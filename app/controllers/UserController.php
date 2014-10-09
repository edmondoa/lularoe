<?php 

class UserController extends \BaseController
{
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function index()
	{
    	$users = $this->user->all();
        $this->layout->content = \View::make('user.index', compact('users'));
	}

	public function create()
	{
        $this->layout->content = \View::make('user.create');
	}

	public function store()
	{
		$data = Input::all();
		echo"<pre>"; print_r('Whatevs'); echo"</pre>";
		echo"<pre>"; print_r($data); echo"</pre>";
		exit;
		$data['phone'] = formatPhone($data['phone']);
		$rules = User::$rules;
		$rules['email'] = 'required|unique:users,email';
		$rules['address_1'] = 'required';
		$rules['address_2'] = 'sometimes';
		$rules['city'] = 'required';
		$rules['state'] = 'required';
		$rules['zip'] = 'required|digits_between:5,10';
		$rules['dob'] = 'required|before:'.date('Y-m-d',strtotime('18 years ago'));
		$rules['password'] = 'required|confirmed|digits_between:8,12';
		$rules['sponsor_id'] = 'required|digits';
		$check_sponsor_id = User::where('public_id', $data['sponsor_id']);
		if ($check_sponsor_id == UNDEFINED) {
			echo 'Invalid sponsor id';
			exit;
		}

		$validator = Validator::make($data,$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$data['password'] = Hash::make($data['password']);
		$user = User::create($data);
	    $address = Address::create([
	    	'address'=>$data['address_1'],
	    	'address2'=>$data['address_2'],
	    	'city'=>$data['city'],
	    	'state'=>$data['state'],
	    	'zip'=>$data['zip'],
	    	]);
		$user->addresses()->save($address);
		Auth::loginUsingId($user->id);
		return Redirect::to('payment.create');
	}

	public function show($id)
	{
        $user = $this->user->find($id);
        $this->layout->content = \View::make('user.show')->with('user', $user);
	}

	public function edit($id)
	{
        $user = $this->user->find($id);
        $this->layout->content = \View::make('user.edit')->with('user', $user);
	}

	public function update($id)
	{
        $this->user->find($id)->update(\Input::only('first_name','last_name','email','password','gender','key','code','dob','phone','role_id','sponsor_id','mobile_plan_id','min_commission','disabled'));
        return \Redirect::route('user.show', $id);
	}

	public function destroy($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->user->destroy($id);
			}
			return \Redirect::route('user.index');
		}
		else {
	        $this->user->destroy($id);
	        return \Redirect::route('user.index');
		}
	}
	
	public function delete($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->user->destroy($id);
			}
			return \Redirect::route('user.index')->with('message', 'Users deleted.');;
		}
		else {
	        $this->user->destroy($id);
	        return \Redirect::route('user.index')->with('message', 'User deleted.');;
		}
	}
	
	public function disable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->user->where('id', $id)->update(array('disabled' => 1));
			}
			return \Redirect::route('user.index')->with('message', 'Users disabled.');
		}
		else {
	        $this->user->where('id', $id)->update(array('disabled' => 1));
	        return \Redirect::route('user.index')->with('message', 'User disabled.');;
		}
	}
	
	public function enable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->user->where('id', $id)->update(array('disabled' => NULL));
			}
			return \Redirect::route('user.index')->with('message', 'Users enabled.');;
		}
		else {
	        $this->user->where('id', $id)->update(array('disabled' => NULL));
	        return \Redirect::route('user.index')->with('message', 'User enabled.');;
		}
	}
	
}
