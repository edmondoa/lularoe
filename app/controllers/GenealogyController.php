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
	
	public function team()
	{
		$id = Auth::user()->id;
		$users = User::find($id)->children;
		return View::make('genealogy.team', compact('users'));
	}

}
