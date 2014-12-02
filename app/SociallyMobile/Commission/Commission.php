<?php namespace SociallyMobile\Commission;

use \User;
use \Level;

class Commission extends \BaseController {

	public $tree = [];
	/**
	* 
	*
	* @param int $sponsor_id, int $level
	* @return 
	*/
	public function next_up($sponsor_id,$level){
		$sponsor = User::find($sponsor_id);
		$level ++;
		if($sponsor->sponsor_id != 0)
		{
			$this->next_up($sponsor->sponsor_id,$level);
		}
		else
		{
		}
	}
	
	/**
	* Counts the generations between one rep and another
	*
	* @param  
	* @return int $generations
	*/
	public function count_up($sponsor_id,$level = 0){
		$sponsor = User::find($sponsor_id);
		if((isset($sponsor->id))&&($sponsor->sponsor_id != 0))
		{
			return $this->count_up($sponsor->sponsor_id,$level+1); //nest the call until we get to the frontline
		}
		else
		{
			return $level;
		}
	}
	
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function level_up($sponsor_id,$level = 0,$from_id=null){
		$sponsor = User::find($sponsor_id);
		if(is_null($from_id)) $from_id = $sponsor_id;
		if((isset($sponsor->id))&&(!is_null($sponsor->sponsor_id)))
		{
			if($sponsor_id != $from_id)
			{
				$level_data = ['ancestor_id'=>$sponsor->id,'user_id'=>$from_id,'level'=>$level];
				$new_level = Level::updateOrCreate($level_data);
			}
			return $this->level_up($sponsor->sponsor_id,$level+1,$from_id); //nest the call until we get to the frontline
		}
		else
		{
			//echo "It must be a topline";
			if($sponsor_id != $from_id)
			{
				$level_data = ['ancestor_id'=>$sponsor->id,'user_id'=>$from_id,'level'=>$level];
				$new_level = Level::updateOrCreate($level_data);
			}
			return true;
		}
	}
	
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function level_up_reassign($sponsor_id,$level = 0,$from_id=null){
		$sponsor = User::find($sponsor_id);
		if(is_null($from_id)) $from_id = $sponsor_id;
		if((isset($sponsor->id))&&($sponsor->sponsor_id != 0))
		{
			if($sponsor_id != $from_id)
			{
				$level_data = ['ancestor_id'=>$sponsor->id,'user_id'=>$from_id,'level'=>$level];
				$new_level = Level::updateOrCreate($level_data);
			}
			return $this->level_up_reassign($sponsor->sponsor_id,$level+1,$from_id); //nest the call until we get to the frontline
		}
		else
		{
			if($sponsor_id != $from_id)
			{
				$level_data = ['ancestor_id'=>$sponsor->id,'user_id'=>$from_id,'level'=>$level];
				$new_level = Level::updateOrCreate($level_data);
			}
			return true;
		}
	}
	
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function count_down($rep_id,$level){
		$sponsor = User::find($rep_id)->children;
		foreach($frontline as $rep)
		{
			
		}
	}
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function delete_levels_down($rep_id,$level = 1){
		$frontline = User::find($rep_id)->frontline;
		foreach($frontline as $rep)
		{
			Level::where('ancestor_id',$rep->id)->delete();
			Level::where('user_id',$rep->id)->delete();
			$this->delete_levels_down($rep->id,$level+1);
		}
		return $level;
	}
	
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function get_levels_down($rep_id,$level){
		$frontline = User::find($rep_id)->children;
		$level ++;
		foreach($frontline as $rep)
		{
			$this->get_levels_down($rep->id,$level);
		}
		return $level;
	}

	/**
	* 
	*
	* @param int rep_id 
	* @return multi-dimensional array of generational hierarchy
	*/
	public function get_org_tree($rep_id,$level = 0){
		if(is_null($level))
		{
			$level = $rep_id;
		}
		$frontline = User::find($rep_id)->frontline;
		$user = User::find($rep_id);
		$children = []; //ensure we have an empty array to start with
		$generation = new \stdClass; //create a new object of stdClass
		$generation->id = $user->id;
		$generation->level = $level;
		$generation->name = $user->first_name." ".$user->last_name;
		$generation->rank = $user->rank_name . ' (rank level ' . $user->rank_id . ')';
		$generation->phone = $user->phone;
		$generation->email = substr($user->email,0,20);
		if (strlen($user->email) > 20) $generation->email .= '...';
		
		//$generation->children = array();
		$count = 0;
		foreach($frontline as $rep)
		{
			$count ++;
			$children[] = $this->get_org_tree($rep->id,$level+1); // recursively add children
		}
		if(count($children) > 0) //if there were children add them to the object
		{
			$generation->children = $children;
		}
		return $generation;
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function get_org_tree_2($rep_id){
		$frontline = User::find($rep_id)->frontline;
		echo "<ul>";
		foreach($frontline as $rep)
		{
			echo "<li>".$rep->id." - ".$rep->first_name." ".$rep->last_name;
			$this->get_org_tree_2($rep->id);
			echo "</li>";
		}
		echo"</ul>";
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function set_levels_down($rep_id,$level = 1){
		$frontline = User::find($rep_id)->frontline;
		foreach($frontline as $rep)
		{
			//set_time_limit(120);
			//echo $rep->first_name." ".$rep->last_name." - ".$level."<br />";
			$this->level_up($rep->id);
			$this->set_levels_down($rep->id,$level+1);
		}
		return $level;
	}
	
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function set_levels_down_reassign($rep_id,$level = 1){
		$frontline = User::find($rep_id)->frontline;
		foreach($frontline as $rep)
		{
			set_time_limit(30);
			$this->level_up_reassign($rep->id);
			$this->set_levels_down_reassign($rep->id,$level+1);
		}
		return $level;
	}
	
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function organize_hierarchy(){
		$reps = User::take(3)->skip(10)->get();
		foreach($reps as $rep)
		{
			if ($rep->sponsor_id == 0) continue; //skip frontline
			$this->next_up($rep->sponsor_id,1);
		}
		return ;
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function getDownlineVolume($rep_id)
	{
		
	}
		
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function getLevelOneVolume($rep_id)
	{
		
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function isQualifiedLine($rep_id)
	{
		
	}
		
	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function hasLeadershipRequirements($rep_id, $requirements)
	{
		
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function assessPercentages($rep_id)
	{
		
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function countDownlineByLevel($rep_id)
	{
		
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function getAllDownline($rep_id)
	{
		// returns rep objects with their level and rank
	}

}
?>
