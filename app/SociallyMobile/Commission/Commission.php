<?php namespace SociallyMobile\Commission;

use \User;
use \Level;

class Commission extends \BaseController {
	public $level_count;
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
	
	public function count_up($sponsor_id,$level = 0){
		$sponsor = \User::find($sponsor_id);
		if((isset($sponsor->id))&&($sponsor->sponsor_id != 0))
		{
			return $this->count_up($sponsor->sponsor_id,$level+1); //nest the call until we get to the frontline
		}
		else
		{
			return $level;
		}
	}
	
	public function level_up($sponsor_id,$level = 0,$from_id=null){
		$sponsor = \User::find($sponsor_id);
		if(is_null($from_id)) $from_id = $sponsor_id;
		if((isset($sponsor->id))&&($sponsor->sponsor_id != 0))
		{
			//echo "Original:".$from_id." | ".$sponsor->first_name." ".$sponsor->last_name." - level: ".$level."<br />\r\n";
			if($sponsor_id != $from_id)
			{
				$level_data = ['ancestor_id'=>$sponsor->id,'user_id'=>$from_id,'level'=>$level];
				//echo"<pre>"; print_r($level_data); echo"</pre>";
				$new_level = Level::updateOrCreate($level_data);
			}
			return $this->level_up($sponsor->sponsor_id,$level+1,$from_id); //nest the call until we get to the frontline
		}
		else
		{
			//echo "Original:".$from_id." | Frontline:".$sponsor->first_name." ".$sponsor->last_name." - level: ".$level."<br />\r\n";
			if($sponsor_id != $from_id)
			{
				$level_data = ['ancestor_id'=>$sponsor->id,'user_id'=>$from_id,'level'=>$level];
				//echo"<pre>"; print_r($level_data); echo"</pre>";
				$new_level = Level::updateOrCreate($level_data);
			}
			return true;
		}
	}
	
	public function count_down($rep_id,$level){
		$sponsor = \User::find($rep_id)->children;
		//return 'Testing:'.$string;
		foreach($frontline as $rep)
		{
			
		}
	}
	
	public function get_levels_down($rep_id,$level){
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

	public function set_levels_down($rep_id,$level){
		$frontline = User::find($rep_id)->frontline;
		foreach($frontline as $rep)
		{
			$this->level_up($rep->id);
			$this->set_levels_down($rep->id,$level+1);
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

	function getDownlineVolume($rep_id)
	{
		
	}
		
	function getLevelOneVolume($rep_id)
	{
		
	}

	function isQualifiedLine($rep_id)
	{
		
	}
		
	function hasLeadershipRequirements($rep_id, $requirements)
	{
		
	}

	function assessPercentages($rep_id)
	{
		
	}

	function countDownlineByLevel($rep_id)
	{
		
	}

	function getAllDownline($rep_id)
	{
		// returns rep objects with their level and rank
	}

}
?>
