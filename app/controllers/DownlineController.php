<?php 

class DownlineController extends \BaseController
{
	
	/**
	 * Data only
	 */
	
	public function immediateDownline($id)
	{
		$user = User::findOrFail($id);
		return View::make('downline.immediate', compact('user'));
	}
	
	public function allDownline($id)
	{
		$user = User::findOrFail($id);
		return View::make('downline.all', compact('user'));
	}

}