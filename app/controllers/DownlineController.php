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
			if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
				$total_users = User::all()->count();
				return View::make('downline.all', compact('user', 'total_users'));
			}
			return View::make('downline.all', compact('user'));
		}
	}

	public function visualization($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::find($id);
			if ($user->id == Auth::user()->id) $name = 'My';
			else $name = $user->first_name . ' ' . $user->last_name . "'s";
			return View::make('downline.visualization', compact('user', 'name'));
		}
	}

}
