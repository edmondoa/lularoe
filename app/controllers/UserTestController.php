<?php 

class UserTestController extends \BaseController
{
	protected $userTest;

	public function __construct(UserTest $userTest)
	{
		$this->userTest = $userTest;
	}

	public function index()
	{
    	$userTests = $this->userTest->all();
        $this->layout->content = \View::make('userTest.index', compact('userTests'));
	}

	public function create()
	{
        $this->layout->content = \View::make('userTest.create');
	}

	public function store()
	{
        $this->userTest->store(\Input::only('first_name','last_name','email','password','gender','key','code','dob','phone','role_id','sponsor_id','mobile_plan_id','min_commission','disabled'));
        return \Redirect::route('userTest.index');
	}

	public function show($id)
	{
        $userTest = $this->userTest->find($id);
        $this->layout->content = \View::make('userTest.show')->with('userTest', $userTest);
	}

	public function edit($id)
	{
        $userTest = $this->userTest->find($id);
        $this->layout->content = \View::make('userTest.edit')->with('userTest', $userTest);
	}

	public function update($id)
	{
        $this->userTest->find($id)->update(\Input::only('first_name','last_name','email','password','gender','key','code','dob','phone','role_id','sponsor_id','mobile_plan_id','min_commission','disabled'));
        return \Redirect::route('userTest.show', $id);
	}

	public function destroy($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->userTest->destroy($id);
			}
			return \Redirect::route('userTest.index');
		}
		else {
	        $this->userTest->destroy($id);
	        return \Redirect::route('userTest.index');
		}
	}
	
	public function delete($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->userTest->destroy($id);
			}
			return \Redirect::route('userTest.index')->with('message', 'UserTests deleted.');;
		}
		else {
	        $this->userTest->destroy($id);
	        return \Redirect::route('userTest.index')->with('message', 'UserTest deleted.');;
		}
	}
	
	public function disable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->userTest->where('id', $id)->update(array('disabled' => 1));
			}
			return \Redirect::route('userTest.index')->with('message', 'UserTests disabled.');
		}
		else {
	        $this->userTest->where('id', $id)->update(array('disabled' => 1));
	        return \Redirect::route('userTest.index')->with('message', 'UserTest disabled.');;
		}
	}
	
	public function enable($id)
	{
		if ($id == 0) {
			foreach (Input::only('ids') as $id) {
				$this->userTest->where('id', $id)->update(array('disabled' => NULL));
			}
			return \Redirect::route('userTest.index')->with('message', 'UserTests enabled.');;
		}
		else {
	        $this->userTest->where('id', $id)->update(array('disabled' => NULL));
	        return \Redirect::route('userTest.index')->with('message', 'UserTest enabled.');;
		}
	}
	
}
