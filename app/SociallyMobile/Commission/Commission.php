<?php namespace SociallyMobile\Commission;

//use \User;

class Commission extends \BaseController {

	public function test($string){
		return 'Testing:'.$string;
	}
	
	public function organize_hierarchy(){
		$reps = \User::all();
		foreach($reps as $rep)
		{
			if ($rep->sponsor_id == 0) continue; //skip frontline
			
			echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
		}
		return ;
	}
}
