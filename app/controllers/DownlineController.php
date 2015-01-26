<?php 

class DownlineController extends \BaseController
{
	
	public function newDownline($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::findOrFail($id);
			$new_descendants_count_30 = User::find($user->id)->new_descendants_count_30();
			$new_descendants_count_7 = User::find($user->id)->new_descendants_count_7();
			$new_descendants_count_1 = User::find($user->id)->new_descendants_count_1();
			return View::make('downline.new', compact('user', 'new_descendants_count_30', 'new_descendants_count_7', 'new_descendants_count_1'));
		}
		else
		{
			return Redirect::to('dashboard');
		}
	}
	
	public function immediateDownline($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::findOrFail($id);
			return View::make('downline.immediate', compact('user'));
		}
		else
		{
			return Redirect::to('dashboard');
		}
	}
	
	public function allDownline($id)
	{
		//return dd(Auth::user()->hasRepInDownline($id));
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::findOrFail($id);
			if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
				$total_users = User::all()->count();
				return View::make('downline.all', compact('user', 'total_users'));
			}
			return View::make('downline.all', compact('user'));
		}
		else
		{
			return Redirect::to('dashboard');
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
	
	public function states($id)
	{
		if (Auth::user()->hasRepInDownline($id) || Auth::user()->id == $id || Auth::user()->hasRole(array('Superadmin', 'Admin'))) {
			$user = User::find($id);
			if ($user->id == Auth::user()->id) $name = 'My';
			else $name = $user->first_name . ' ' . $user->last_name . "'s";
			return View::make('downline.states', compact('user', 'name'));
		}
	}

}