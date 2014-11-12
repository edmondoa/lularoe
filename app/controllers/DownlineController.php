<?php 

class DownlineController extends \BaseController
{
	
	public function immediateDownline($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::findOrFail($id);
			return View::make('downline.immediate', compact('user'));
		}
	}
	
	public function allDownline($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::findOrFail($id);
			return View::make('downline.all', compact('user'));
		}
	}

	public function visualization($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$users = User::find($id)->descendants->toArray();
			return View::make('downline.visualization', compact('users'));
		}
	}

}