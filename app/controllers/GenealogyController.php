<?php 

class GenealogyController extends \BaseController
{
	
	/**
	 * Data only
	 */
	public function getImmediateDownline($id) {
		// return User::find($id)->children()->get();
		return DB::table('users')->where('sponsor_id', $id)->get();
		
	}
	
	public function downline($id)
	{
		$user = User::findOrFail($id);
		return View::make('genealogy.downline', compact('user'));
	}

}
