<?php namespace SociallyMobile\Commission;

use \User;

class Commission extends \BaseController {

	public function test($string){
		return 'Testing:'.$string;
	}

	public function next_up($sponsor_id,$level){
		$sponsor = \User::find($sponsor_id);
		$level ++;
		if($sponsor->sponsor_id != 0)
		{
			echo "->".$sponsor->first_name." ".$sponsor->last_name."(".$level.") ";
			$this->next_up($sponsor->sponsor_id,$level);
		}
		else
		{
			echo "<b>->FRONTLINE:</b>".$sponsor->first_name." ".$sponsor->last_name;
		}
		//return 'Testing:'.$string;
	}
	
	public function count_up($sponsor_id,$level){
		$sponsor = \User::find($sponsor_id);
		$level ++;
		if($sponsor->sponsor_id != 0)
		{
			//echo "->".$sponsor->first_name." ".$sponsor->last_name."(".$level.") ";
			$this->count_up($sponsor->sponsor_id,$level);
		}
		else
		{
			return $level;
		}
		//return 'Testing:'.$string;
	}
	
	public function count_down($rep_id,$level){
		$sponsor = \User::find($rep_id)->children;
		//return 'Testing:'.$string;
		foreach($frontline as $rep)
		{
			
		}
	}
	
	public function get_levels_down($rep_id,$level,$ancestors){
		$frontline = \User::find($rep_id)->children;
		echo"<pre>"; print_r($ancestors); echo"</pre>"; 
		$level ++;
		foreach($frontline as $rep)
		{
			//echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
			//$user = Level::firstOrNew(array('user_id' => $rep->id,'ancestor_id',));
			//$user->foo = Input::get('foo');
			//$user->save();
			echo $rep->first_name." ".$rep->last_name."(".$level.")<br />";
			$ancestors[] = ['name'=>$rep->first_name." ".$rep->last_name,'id'=>$rep->id,'level'=>$level];
			$this->get_levels_down($rep->id,$level,$ancestors);
		}
		return $level;
		//return 'Testing:'.$string;
	}
	
	public function organize_hierarchy(){
		$reps = User::take(3)->skip(10)->get();
		foreach($reps as $rep)
		{
			//echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
			if ($rep->sponsor_id == 0) continue; //skip frontline
			//step throught each ancestor
			echo "<p><b>Rep:</b>".$rep->first_name." ".$rep->last_name;
			//$sponsor = \User::find($rep->sponsor_id);
			$this->next_up($rep->sponsor_id,1);
			echo "</p>";

			//echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
		}
		return ;
	}
}
?>
