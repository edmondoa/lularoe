<?php 

class ProfilesController extends \BaseController
{
	protected $profiles;

	public function __construct(Profiles $profiles)
	{
		$this->profiles = $profiles;
	}

	public function index()
	{
    	$profiles = $this->profiles->all();
        $this->layout->content = \View::make('profiles.index', compact('profiles'));
	}

	public function create()
	{
        $this->layout->content = \View::make('profiles.create');
	}

	public function store()
	{
        $this->profiles->store(\Input::only('public_name','public_content','receive_company_email','receive_company_sms','receive_upline_email','receive_upline_sms','receive_downline_email'));
        return \Redirect::route('profiles.index');
	}

	public function show($id)
	{
        $profiles = $this->profiles->find($id);
        $this->layout->content = \View::make('profiles.show')->with('profiles', $profiles);
	}

	public function edit($id)
	{
        $profiles = $this->profiles->find($id);
        $this->layout->content = \View::make('profiles.edit')->with('profiles', $profiles);
	}

	public function update($id)
	{
        $this->profiles->find($id)->update(\Input::only('public_name','public_content','receive_company_email','receive_company_sms','receive_upline_email','receive_upline_sms','receive_downline_email'));
        return \Redirect::route('profiles.show', $id);
	}

	public function destroy($id)
	{
        $this->profiles->destroy($id);
        return \Redirect::route('profiles.index');
	}

}
