<?php 

class DataOnlyController extends \BaseController
{

	public function getImmediateDownline($id) {
		return User::find($id)->frontline;
	}
	
	public function getAllDownline($id) {
		return User::find($id)->descendants;
	}

}