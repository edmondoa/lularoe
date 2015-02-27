<?php namespace LLR\Commission;

use \User;
use \Rank;
use \Level;

class Commission extends \BaseController {

	public $tree = [];
	public $commission_period;

	/**
	* 
	*
	* @param int $sponsor_id, int $level
	* @return 
	*/
	public function setCommissionPeriod($date){
		$this->commission_period = date('Y-m-00',strtotime($date));
	}
	
	/**
	* 
	*
	* @param int $repId
	* @return 
	*/
	public function getUserStats($repId){
		// requires a commission period be set
		$rep = User::findOrFail($repId);
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		$stats = $rep->stats()->where('userstats.commission_period',$this->commission_period)->first();
		if(!$stats)
		{
			//i should maybe expand this to create a record when one is not present.
			\Log::info($descendants->last_name.", ".$descendants->first_name." ... no stats found");
			throw new \Exception('Stat record not found.');
			return;
		}
		return $stats;
		
	}
	
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
		if (!$user->hide_phone) $generation->phone = $user->phone;
		if (!$user->hide_email) $generation->email = substr($user->email,0,20);
		if ($user->block_email) $generation->block_email = true;
		if ($user->block_sms) $generation->block_sms = true;
		if (strlen($user->email) > 20 && isset($generation->email)) $generation->email .= '...';
		
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
	public function get_org_tree_visual($rep_id){
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
			$this->level_up($rep->id);
			$this->set_levels_down($rep->id,$level+1);
		}
		return $level;
	}
	
	/**
	* 
	*
	* @param  int $rep_id, int $level
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
	protected function countQualifiedLines($rep_id,$rank_reqd_id,$qty)
	{
		$count = 0;
		foreach(\User::find($rep_id)->frontline as $frontline)
		{
			if($this->isQualifiedLine($rep_id,$rank_reqd_id))
			{
				$count++;
			}
		}
		return ($count >= $qty)?true:false;
	}
		
	/**
	* 
	*
	* @param  int $rep_id, int $rank_reqd_id
	* @return boolean
	*/
	protected function isQualifiedLine($rep_id,$rank_reqd_id)
	{
		$rep = \User::find($rep_id);
		if($rep->rank_id == $rank_reqd_id)
		{
			return true;
		}
		foreach($rep->descendants as $descendant)
		{
			if($descendant->rank_id == $rank_reqd_id)
			{
				return true;
			}
		}
		return false;
	}
		
	/**
	* 
	*
	* @param int rep_id   
	* @return int downline_volume
	*/
	public function getDownlineVolume($rep_id,$date = null,$update_stats = true)
	{
		\DB::connection()->disableQueryLog();
		if(is_null($date))
		{
			$commission_period = date('Y-m-00');
			$date = date('Y-m-d');
		}
		else
		{
			$commission_period = date('Y-m-00',strtotime($date));
		}
		$business_dollar_volume = 0;
		$business_points_volume = 0;
		foreach(User::find($rep_id)->descendants_sm()->get() as $descendant)
		{
			$dollar_volume = $descendant->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_price');
			$points_volume = $descendant->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_points');
			//echo"<pre>"; print_r($volume); echo"</pre>"; 
			$business_dollar_volume += $dollar_volume;
			$business_points_volume += $points_volume;
		}
		if($update_stats === true)
		{
			$stat = \Userstat::firstOrCreate(array('user_id' => $rep_id,'commission_period'=>$commission_period));
			$stat->commission_period = $commission_period;
			$stat->business_dollar_volume = $business_dollar_volume;
			$stat->business_points_volume = $business_points_volume;
			$stat->update();
			$user = User::find($rep_id);
			$user->stats()->save($stat);
		}

		return $business_dollar_volume;
	}
		
	/**
	* 
	*
	* @param int rep_id   
	* @return boolean
	*/
	public function checkDownlineVolume($rep_id,$accumulated =0)
	{
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		$frontline = User::find($rep_id)->frontline;
		foreach($frontline as $rep)
		{
			set_time_limit(30);
			if($rep->rank_id > 2) continue; //skip all organizations of trainer or above
			$points_volume = $rep->orders()->whereRaw("MONTH(created_at)=MONTH('".$this->commission_period."') AND YEAR(created_at)=YEAR('".$this->commission_period."')")->sum('total_points'); 
			$accumulated += $points_volume;
			$accumulated += $this->checkDownlineVolume($rep->id);
		}
		return $accumulated;
	}
		
	/**
	* 
	*
	* @param int rep_id   
	* @return decimal $frontline_volume
	*/
	public function getFrontlineVolume($rep_id,$date = null,$update_stats = true)
	{
		\DB::connection()->disableQueryLog();
		if(is_null($date))
		{
			$commission_period = date('Y-m-00');
			$date = date('Y-m-d');
		}
		else
		{
			$commission_period = date('Y-m-00',strtotime($date));
		}
		$frontline_points_volume = 0;
		$frontline_dollar_volume = 0;
		foreach(User::find($rep_id)->frontline as $frontline)
		{
			$dollar_volume = $frontline->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_price'); 
			$points_volume = $frontline->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_points'); 
			$frontline_dollar_volume += $dollar_volume;
			$frontline_points_volume += $points_volume;
		}
		if($update_stats === true)
		{
			$stat = \Userstat::firstOrCreate(array('user_id' => $rep_id,'commission_period'=>$commission_period));
			//echo"<pre>"; print_r($stat); echo"</pre>";
			$stat->commission_period = $commission_period;
			$stat->fl_dollar_volume = $frontline_dollar_volume;
			$stat->fl_points_volume = $frontline_points_volume;
			$stat->save();
			$user = User::find($rep_id);
			//echo"<pre>"; print_r($user); echo"</pre>";
			$user->stats()->save($stat);
		}
		return $frontline_dollar_volume;
	}

	/**
	* 
	*
	* @param [,date $date=null [,bool $update_stats=true]]
	* @return null
	*/
	public function setUserStats($rep_id,$date = null,$update_stats = true)
	{
		\DB::connection()->disableQueryLog();
		if(is_null($date))
		{
			$commission_period = date('Y-m-00');
			$date = date('Y-m-d');
		}
		else
		{
			$commission_period = date('Y-m-00',strtotime($date));
		}
		if($update_stats === true)
		{
			$user = User::find($rep_id);
			$dollar_volume = $user->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_price'); 
			$points_volume = $user->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_points'); 
			$stat = \Userstat::firstOrCreate(array('user_id' => $rep_id,'commission_period'=>$commission_period));
			//echo"<pre>"; print_r($stat); echo"</pre>";
			$stat->commission_period = $commission_period;
			$stat->personal_points_volume = $points_volume;
			$stat->personal_dollar_volume = $dollar_volume;
			$stat->save();
			//echo"<pre>"; print_r($user); echo"</pre>";
			$user->stats()->save($stat);
		}
		$this->getDownlineVolume($rep_id,$date);
		$this->getFrontlineVolume($rep_id,$date);
		set_time_limit(30);
		return;
	}

	/**
	* 
	*
	* @param [,date $date=null [,bool $update_stats=true]]
	* @return null
	*/
	public function setAllUserStats($date = null,$update_stats = true)
	{
		set_time_limit(120);
		\DB::connection()->disableQueryLog();
		$users = \DB::table('users')->where('id','!=',0)->get(['id']);
		foreach($users as $rep)
		{
			$this->setUserStats($rep->id,$date,true);
		}
		return;
	}

	/**
	* 
	*
	* @param  
	* @return 
	*/
	public function setRank($rep_id,$show_steps = false)
	{
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		$result = [];
		//return User::find($rep_id);
		\Cache::forget('user_'.$rep_id.'_rank');
		\Cache::forget('user_'.$rep_id.'_ranks');
		$rep = \User::find($rep_id);
		$stats = $rep->stats()->where('userstats.commission_period',$this->commission_period)->first();
		if(!$stats) return;
		$result['pv'] = $stats->personal_points_volume;
		$result['flv'] = $stats->fl_points_volume;
		$result['gv'] = $stats->business_points_volume;
		\Log::info($rep->first_name." ".$rep->last_name."##########################################");
		//echo"<pre>"; print_r($stats->toArray()); echo"</pre>";
		//echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
		//exit;
		$ranks = \Rank::orderBy('id', 'DESC')->get();
		//return $ranks;
		foreach($ranks as $rank)
		{
			set_time_limit(30);
			// 1st check for personally sponsored
			if($rep->personally_sponsored_count < $rank->ps_minimum)
			{
				\Log::info(" - Failed the PS minimum rank test for ".$rank->name.". Required:".$rank->ps_minimum." Actual:".$rep->personally_sponsored_count.".");
				continue; //didn't pass so we skip the rest of the tests
			}
			else
			{
				$result[] = " - passed the PS minimum rank test for ".$rank->name;
				\Log::info(" - passed the PS minimum rank test for ".$rank->name);
			}

			//Next, let's check PV
			if($stats->personal_points_volume < $rank->pv_minimum)
			{
				$bonus = 0;
				foreach($rep->personally_sponsored()->get() as $frontline)
				{
					$ps_stats = $frontline->stats()->where('userstats.commission_period',date('Y-m-00'))->first();
					if($ps_stats->personal_points_volume >= 3500)
					{
						$bonus += 1000;
						//echo"<pre>"; print_r($stats); echo"</pre>";
					}
				}
				if(($stats->personal_points_volume + $bonus) < $rank->pv_minimum)
				{
					\Log::info(" - Failed the PV minimum rank test for ".$rank->name.". Required:".$rank->pv_minimum." Actual:".($stats->personal_points_volume + $bonus).".");
					continue; //didn't pass so we skip the rest of the tests
				}
			}
			else
			{
				$result[] = " - passed the PV minimum rank test for ".$rank->name;
				\Log::info(" - passed the PV minimum rank test for ".$rank->name);
			}
			
			//Next, let's check GV
			if($rank->gv_minimum > 0)
			{
				$group_volume = (int)$this->checkDownlineVolume($rep->id);
				if($group_volume<$rank->gv_minimum)
				{
					\Log::info(" - Failed the GV minimum rank test for ".$rank->name.". Required:".$rank->gv_minimum." Actual:".$group_volume.".");
					continue; //didn't pass so we skip the rest of the tests
				}
				else
				{
					$result[] = " - passed the GV minimum rank test for ".$rank->name;
					\Log::info(" - passed the GV minimum rank test for ".$rank->name);
				}
			}
			//Next, let's check Downline requirement
			if($rep->descendant_count < $rank->downline_min)
			{
				\Log::info(" - Failed the Downline minimum rank test for ".$rank->name.". Required:".$rank->downline_min." Actual:".$rep->descendant_count.".");
				continue; //didn't pass so we skip the rest of the tests
			}
			else
			{
				$result[] = " - passed the Downline minimum rank test for ".$rank->name;
				\Log::info(" - passed the Downline minimum rank test for ".$rank->name);
			}
			
			if($rank->leadership_qty > 0)
			{
				if(!$this->countQualifiedLines($rep_id,$rank->leadership_rank_id,$rank->leadership_qty))
				{
					\Log::info(" - FAILED the leadership rank test for ".$rank->name);
					continue;
				}
			}
			else
			{
				$result[] = " - passed the leadership rank test for ".$rank->name;
				\Log::info(" - passed the leadership rank test for ".$rank->name);
			}

			if($rep->rank_id != $rank->id)
			{
				$result[] = $rep->rank_id." isn't the same as ".$rank->id;
				$rep->ranks()->attach($rank->id);
				if($show_steps)
				{
					$result[] = 'New rank assigned';
					$result['rep'] = $rep;
					\Log::info("New rank assigned for "." - - ".$rank->name);
					$result['rank'] = $rank;
					return $result;
				}
				\Log::info("New rank assigned:".$rank->name);
				return true;
			}
			if($show_steps)
			{
				$result['rep'] = $rep;
				$result['rank'] = $rank;
				return $result;
			}
			return false;

		}
		return $result;
	}

	/**
	* 
	*
	* @param  
	* @return int $count all updated reps
	*/
	public function updateRanks($date,$repId = 0)
	{
		$this->setCommissionPeriod($date);
		\DB::connection()->disableQueryLog();
		$count = 0;
		$frontline = User::find($repId)->frontline;
		foreach($frontline as $rep)
		{
			set_time_limit(60);
			$count += $this->updateRanks($date,$rep->id);
		}
		$count ++;
		if($this->setRank($repId))
		{
			return $count;
		}
	}

	/**
	* 
	* Calculates commission bonuses for a single user
	* @param  
	* @return 
	*/
	//private function calculate($repId)
	public function calculate($repId)
	{
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		$rep = User::find($repId);

		$rank = Rank::find($rep->rank_id);
		if (!isset($rank->id)) return;
		//return $rank;
		if($rep->rank_id < 2) //no commissions paid to Fashion Consultants or non
		{
			return;
		}
		$sum = 0;
		$infinity = 0;
		$infinity_amount = 0;
		$response = [];
		$distributions = [];
		//$personally_sponsored = $rep->personally_sponsored();
		//return $personally_sponsored->get();
		/*
		SET FOREIGN_KEY_CHECKS=0;
		TRUNCATE commissionlines; 
		SET FOREIGN_KEY_CHECKS=1;

		*/
		foreach($rep->descendants as $descendants)
		{
			\Log::info($descendants->last_name.", ".$descendants->first_name." ... running commission");
			$stats = $descendants->stats()->where('userstats.commission_period',$this->commission_period)->first();
			if(!$stats)
			{
				\Log::info($descendants->last_name.", ".$descendants->first_name." ... no stats found");
				continue;
			}
			if($descendants->level == 1)
			{

				if($stats->personal_dollar_volume > 0)
				{
					if($descendants->original_sponsor_id == $repId)
					{
						$amount = round(($stats->personal_dollar_volume * $rank->frontline_commission),2);
						$description = 'Commission paid for Personally Sponsored Override Bonus';
					}
					else
					{
						$amount = round(($stats->personal_dollar_volume * $rank->org_commission),2);
						$description = 'Commission paid for Frontline Override Bonus';
					}
					//Generate a commission record for personally downline
					$commission = \Commissionline::create([
						'amount'=> $amount,
						'description'=>$description,
						'commission_period'=>$this->commission_period,
					]);

					$commission->user()->associate($rep)->save();
					$commission->source()->associate($descendants)->save();
					\Log::info($descendants->last_name.", ".$descendants->first_name." - Bonus:Personally Sponsored Override Bonus - Amount:".$amount." ");
					$sum += $amount;
				}
			}
			else
			{
				\Log::info('This was in the infinity group');
				$infinity++;
				$distribution = $this->infinity($descendants->id);

				if(isset($distribution[$rep->id]))
				{
					$infinity_value = (isset($distribution[$rep->id]['amount']))?$distribution[$rep->id]['amount']:0;
					$description = (isset($distribution[$rep->id]['description']))?$distribution[$rep->id]['description']:'';
					$commission = \Commissionline::create([
						'amount'=>$infinity_value,
						'description'=>$distribution[$rep->id]['description'],
						'commission_period'=>date('Y-m-00',strtotime('last month')),
					]);
					$commission->user()->associate($rep)->save();
					$commission->source()->associate($descendants)->save();
					//\Log::info($descendants->last_name.", ".$descendants->first_name." - Level:Infinity - Amount:".$infinity_value." ");
					$infinity_amount += $infinity_value;
				}
			}
		}

		$response['sum'] = $sum;
		$response['infinity'] = $infinity;
		$response['infinity_amount'] = $infinity_amount;
		//$response['dist'] = $distributions;
		$response['total_commission_earned'] = $response['infinity_amount'] + $response['sum'];
		//$response['rep'] = User::find($repId);
		return $response;
	}

	/**
	* 
	* Calculates commission bonuses for all users
	* @param  
	* @return 
	*/
	//private function calculate($repId)
	public function runCommissions($date)
	{
		if(strtotime($date) === false) throw new \Exception('Commission period not specified.');
		$this->commission_period = date('Y-m-00',strtotime($date));
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		foreach(User::all() as $rep)
		{
			$this->calculate($rep->id);
		}

	}

	/**
	* 
	*
	* @param  
	* @return int $count all updated reps
	*/
	public function infinity($repId)
	{
		//requires commission period to be set in the class
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		//gets the accumulated stats for this rep or
		$stats = $this->getUserStats($repId);
		//return $stats;
		$distribution =array();
		$rep = User::find($repId);
		\Cache::forget('user_'.$repId.'_ancestors');

		$ancestors = $rep->ancestors;
		$ancestors = $ancestors->sortBy('level');
		//return $ancestors;
		$total_available = 0;
		$ranking = [];
		$high_rank = 0;
		$maximum_multiplier = 0.03;
		//$total_available_commission = round($stats->personal_dollar_volume*$maximum_multiplier,2);
		foreach($ancestors as $ancestor)
		{
			//skip lower-level ancestors
			if($ancestor->rank_id < 3) continue;
			//loop through trainers/leaders
			if($ancestor->rank_id >= 3)
			{
				$ancestor_rank = $ancestor->ranks()->first();
				$ranking[] = $ancestor;
				$generation = count($ranking);
				if($generation===1)
				{
					//this is the closest trainer/leader
					//This leader is entitled to his/her full%
					$amount = round(($stats->personal_dollar_volume*$ancestor_rank->org_commission),2);
					if($amount > 0)
					{
						$distribution[$ancestor->id] = ['rep_id'=>$ancestor->id,'amount'=>$amount,'description'=>'3% Commission paid for Org Override Bonus'];
					}
				}
				elseif($generation===2)
				{
					//this is the closest trainer/leader
					//This leader is entitled to his/her full%
					$amount = round(($stats->personal_dollar_volume*$ancestor_rank->gen_one_ldr_commission),2);
					if($amount > 0)
					{
						$distribution[$ancestor->id] = ['rep_id'=>$ancestor->id,'amount'=>$amount,'description'=>'First Level 1% override bonus for trainer/leader'];
					}
				}
				elseif($generation===3)
				{
					//this is the closest trainer/leader
					//This leader is entitled to his/her full%
					$amount = round(($stats->personal_dollar_volume*$ancestor_rank->gen_two_ldr_commission),2);
					if($amount > 0)
					{
						$distribution[$ancestor->id] = ['rep_id'=>$ancestor->id,'amount'=>$amount,'description'=>'Second Level 1% override bonus for trainer/leader'];
					}
				}
				continue;
				$rank = $ancestor->rank;
				// asuming higest ancestor first, which we can control let's set the portioning of the infinity income for this rep
				if($rank->infinity_value > $total_available)
				{
					// check to see if there is a higher ranking ISM downline or set the total_available initially
					$total_available = $rank->infinity_value;
					//possible reset of existing distribution
				}
				$distribution[$ancestor->id] = ['rep_id'=>$ancestor->id,'amount'=>$rank->infinity_value,'description'=>''];
				//subtract this amount from the previous leaders distribution
				if((isset($last_leader))&&(isset($distribution[$last_leader]['amount']))&&(($distribution[$last_leader]['amount']-$rank->infinity_value)>0))
				{
					$distribution[$last_leader]['amount'] -= $rank->infinity_value;
				}
				elseif(!isset($last_leader))
				{
					
				}
				else
				{
					throw new \Exception('The internet is breaking!!!');
				}
				$last_leader = $ancestor->id;
			}
		}
		//echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
		//return $ranking;
		return $distribution;
	}


}
?>
