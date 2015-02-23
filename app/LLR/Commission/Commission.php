<?php namespace SociallyMobile\Commission;

use \User;
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
	* @param  null
	* @return null
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
		$downline_volume = 0;
		foreach(User::find($rep_id)->descendants_sm()->get() as $descendant)
		{
			$volume = $descendant->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_points');
			//echo"<pre>"; print_r($volume); echo"</pre>"; 
			$downline_volume += $volume;
		}
		if($update_stats === true)
		{
			$stat = \Userstat::firstOrCreate(array('user_id' => $rep_id,'commission_period'=>$commission_period));
			$stat->commission_period = $commission_period;
			$stat->business_volume = $downline_volume;
			$stat->update();
			$user = User::find($rep_id);
			$user->stats()->save($stat);
		}

		return $downline_volume;
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
		$frontline_volume = 0;
		foreach(User::find($rep_id)->frontline as $frontline)
		{
			$volume = $frontline->orders()->whereRaw("MONTH(created_at)=MONTH('".$date."') AND YEAR(created_at)=YEAR('".$date."')")->sum('total_points'); 
			$frontline_volume += $volume;
		}
		if($update_stats === true)
		{
			$stat = \Userstat::firstOrCreate(array('user_id' => $rep_id,'commission_period'=>$commission_period));
			//echo"<pre>"; print_r($stat); echo"</pre>";
			$stat->commission_period = $commission_period;
			$stat->first_level_volume = $frontline_volume;
			$stat->save();
			$user = User::find($rep_id);
			//echo"<pre>"; print_r($user); echo"</pre>";
			$user->stats()->save($stat);
		}
		return $frontline_volume;
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
		$this->getDownlineVolume($rep_id,$date,$update_stats);
		$this->getFrontlineVolume($rep_id,$date,$update_stats);
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
		
/*		User::chunk(250, function($results) use($date,$update_stats)
		{
			foreach($results as $rep) 
			{
				$this->setUserStats($rep->id,$date,$update_stats);
			}
		});
*/		//$users = User::all(['id']);
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
	* @param  int $rep_id, int $rank_reqd_id
	* @return boolean
	*/
	protected function isQualifiedLine($rep_id,$rank_reqd_id)
	{
		foreach(\User::find($rep_id)->descendants_sm()->with('ranks')->get() as $descendant)
		{
			foreach($descendant->currentRank()->get() as $rank)
			{
				if($rank->id == $rank_reqd_id)
				{
					return true;
				}
			}
		}
		return false;
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
	* @param  
	* @return 
	*/
	public function assessPercentages($rep_id,$max_percentage)
	{
		if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		$rep = \User::find($rep_id);
		$rep_stats = $rep->stats()->where('userstats.commission_period',$this->commission_period)->first();

		if($rep_stats->business_volume ==0)
		{
			return true;
		}
		foreach($rep->frontline as $frontline)
		{
			$fl_stats = $frontline->stats()->where('userstats.commission_period',$this->commission_period)->first();

			$percentage = ($fl_stats->business_volume / $rep_stats->business_volume)*100;
			if($fl_stats->business_volume ==0)
			{
				continue;
			}
			if((($fl_stats->business_volume / $rep_stats->business_volume)*100) > $max_percentage)
			{
				
				return false;
			}
		}
		return true;
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
		\Cache::forget('user_'.$rep_id.'_rank');
		\Cache::forget('user_'.$rep_id.'_ranks');
		$rep = \User::find($rep_id);
		$stats = $rep->stats()->where('userstats.commission_period',$this->commission_period)->first();
		$result['flv'] = $stats->first_level_volume;
		$result['bv'] = $stats->business_volume;
		\Log::info($rep->first_name." ".$rep->last_name."##########################################");
		//echo"<pre>"; print_r($stats->toArray()); echo"</pre>";
		//echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
		//exit;
		$ranks = \Rank::orderBy('id', 'DESC')->get();
		//return $ranks;
		foreach($ranks as $rank)
		{
			set_time_limit(30);
			//first check for the FLV
			if ($stats->first_level_volume < (double) $rank->flv_min)
			{
				\Log::info(" - Failed the flv rank test for ".$rank->name);
				continue; //didn't pass so we skip the rest of the tests
			}
			else
			{
				$result[] = " - passed the flv rank test for ".$rank->name;
				\Log::info(" - passed the flv rank test for ".$rank->name);
			}

			//next business volume

			if ($stats->business_volume < $rank->bv_min)
			{
				\Log::info(" - FAILED the bv rank test for ".$rank->name);
				continue; //didn't pass so we skip the rest of the tests
			}
			else
			{
				$result[] = " - passed the bv rank test for ".$rank->name;
				\Log::info(" - passed the bv rank test for ".$rank->name);
			}

			//Check for qualified lines
			if($rank->partner_lines_min > 0)
			{
				if(!$this->countQualifiedLines($rep_id,2,$rank->partner_lines_min))
				{
					\Log::info(" - FAILED the Qualified lines rank test for ".$rank->name);
					continue;
				}
			}
			else
			{
				$result[] = " - passed the Qualified lines rank test for ".$rank->name;
				\Log::info(" - passed the Qualified lines rank test for ".$rank->name);
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

			// Next percentage
			if($stats->business_volume > 0)
			{
				if(!$this->assessPercentages($rep_id,$rank->percentage_max))
				{
					\Log::info(" - FAILED the percentage rank test for ".$rank->name);
					continue;
					
				}
				else
				{
					$result[] = " - passed the percentage rank test for ".$rank->name;
					\Log::info(" - passed the percentage rank test for ".$rank->name);
				}
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
		//return $ranks;
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
	*
	* @param int $repId
	* @return boolean
	*/
	public function setAllFreeService()
	{
		$users = \DB::table('users')->where('id','!=',0)->get(['id']);
		foreach($users as $rep) 
		{
			$this->free_service($rep->id);
		}
/*		User::chunk(1000, function($results)
		{
			foreach($results as $rep) 
			{
				$this->free_service($rep->id);
			}
		});	
*/	}
	/**
	* 
	*
	* @param int $repId
	* @return boolean
	*/
	public function free_service($repId)
	{
		//$this->setCommissionPeriod(date('Y-m-d',strtotime('last month')));
		//if(empty($this->commission_period)) throw new \Exception('Commission period not specified.');
		$rep = User::find($repId)->clearUserCache();
		$rep = User::find($repId);
		if($rep->front_line_count < 8) return false;
		if(!$rep) return false;
		$count_eight = 0;
		$count_twelve = 0;
		$plan_values = [];
		$eight_weeks = date('Y-m-d',strtotime($rep->created_at." + 8 weeks"));
		$twelve_weeks = date('Y-m-d',strtotime($rep->created_at." + 12 weeks"));
		//$rep->twelve_weeks = $twelve_weeks;
		//$rep->eight_weeks = $eight_weeks;
		//$rep->free_service_credit = 0.00;
		if($rep->free_service) //rep has previously qualified for free service
		{
			// make sure rep still qualifies
			// if rep qualifies return true
			if(($rep->free_service_plan == "8-in-8")&&($rep->front_line_count >=8))
			{
				\Log::info("Free service exists for ".$rep->first_name." ".$rep->last_name);
				return true;
			}

			if(($rep->free_service_plan == "12-in-12")&&($rep->front_line_count >=12))
			{
				\Log::info("Free service exists for ".$rep->first_name." ".$rep->last_name);
				return true;
			}
			// Take away the free service
			$rep->free_service_plan = "";
			$rep->free_service = false;
			$rep->free_service_credit = 0;
			$rep->save();
			// else set free service credit to 0
			\Log::info("Free service rescinded for ".$rep->first_name." ".$rep->last_name);
			return false;
			//return 'free service exists';
		}
		else
		{
			$qualifying_lines_eight = [];
			$qualifying_lines_twelve = [];
			foreach($rep->frontline as $frontline)
			{
				//echo"<pre>"; print_r($frontline->plan->toArray()); echo"</pre>";
				$plan_values[$frontline->id] = $frontline->plan->price;
				if($frontline->created_at < $eight_weeks)
				{
					$qualifying_lines_eight[$frontline->id] = $frontline->plan->price;
					$count_eight++;
				}
				if($frontline->created_at < $twelve_weeks)
				{
					$qualifying_lines_twelve[$frontline->id] = $frontline->plan->price;
					$count_twelve++;
				}
			}
			arsort ($plan_values);
			//if($count_eight >= 8)
			if(count($qualifying_lines_eight) >= 8)
			{
				\Log::info($rep->first_name." Newly qualifies for free service - 8-in-8");
				// set free_service_credit with the eight_in_eight toggle
				arsort ($qualifying_lines_eight);
				$plan_values = array_slice($qualifying_lines_eight, 0, 8);
				$rep->free_service_credit = round(array_sum($plan_values)/count($plan_values),2);
				$rep->free_service_plan = "8-in-8";
				$rep->free_service = true;
				unset($rep->frontline);
				//return $rep;
				//return 'eight-in-eight';
				//return true;
			}
			//if($count_twelve >= 12)
			elseif(count($qualifying_lines_twelve) >= 12)
			{
				\Log::info($rep->first_name." Newly qualifies for free service - 12-in-12");
				// set free_service_credit
				arsort ($qualifying_lines_twelve);
				$plan_values = array_slice($qualifying_lines_twelve, 0, 8);
				$rep->free_service_credit = round(array_sum($plan_values)/count($plan_values),2);
				$rep->free_service_plan = "12-in-12";
				$rep->free_service = true;
				unset($rep->frontline);
				//return $rep;
				//return $rep->frontline()->avg();
				//return 'twelve-in-twevle';
				//return true;
			}
			else
			{
				\Log::info($rep->first_name." doesn't qualify for free service - 8-in-8");

			}
			//return false;
		}
		$rep->save();
		return $rep;
	}

	/**
	* 
	*
	* @param  
	* @return int $count all updated reps
	*/
	public function getUpline($repId)
	{
		$rep = User::find($repId);
		// /echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
		// /return $rep;
		if($rep)
		{
			echo $rep->first_name." ".$rep->last_name."<br />\r\n";
			$this->getUpline($rep->sponsor_id);
		}
	}

	/**
	* 
	*
	* @param  
	* @return int $count all updated reps
	*/
	//private function calculate($repId)
	public function calculate($repId)
	{
		$rep = \User::find($repId);

		$plan = \CommissionPlan::where('rank_id',$rep->rank_id)->first();

		$sum = 0;
		$infinity = 0;
		$infinity_amount = 0;
		$response = [];
		$distributions = [];
		foreach($rep->descendants_sm()->get() as $descendant)
		{
			if($descendant->free_service)
			{
				$commission = \Commissionline::create([
					'amount'=>0.00,
					'description'=>'Commissions are not paid for ISMs who qualify for free service. level:'.$descendant->level.' downline',
					'commission_period'=>date('Y-m-00',strtotime('last month')),
				]);
				$commission->user()->associate($rep)->save();
				$commission->source()->associate($descendant)->save();
				return;
			}
			else
			{
				switch ($descendant->level) 
				{
					case 1:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_one_value,
							'description'=>'Commission paid for level:1 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_one_value." ");
						$sum += $plan->level_one_value;
						break;
					case 2:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_two_value,
							'description'=>'Commission paid for level:2 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_two_value." ");
						$sum += $plan->level_two_value;
						break;
					case 3:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_three_value,
							'description'=>'Commission paid for level:3 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_three_value." ");
						$sum += $plan->level_three_value;
						break;
					case 4:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_four_value,
							'description'=>'Commission paid for level:4 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_four_value." ");
						$sum += $plan->level_four_value;
						break;
					case 5:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_five_value,
							'description'=>'Commission paid for level:5 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_five_value." ");
						$sum += $plan->level_five_value;
						break;
					case 6:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_six_value,
							'description'=>'Commission paid for level:6 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_six_value." ");
						$sum += $plan->level_six_value;
						break;
					case 7:
						$commission = \Commissionline::create([
							'amount'=>$plan->level_seven_value,
							'description'=>'Commission paid for level:7 downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:".$descendant->level." - Amount:".$plan->level_seven_value." ");
						$sum += $plan->level_seven_value;
						break;
					
					default:
						$infinity++;
						$distribution = $this->infinity($descendant->id);

						$infinity_value = (isset($distribution[$rep->id]['amount']))?$distribution[$rep->id]['amount']:0;
						$commission = \Commissionline::create([
							'amount'=>$infinity_value,
							'description'=>'Commission paid for level:Infinity downline',
							'commission_period'=>date('Y-m-00',strtotime('last month')),
						]);
						$commission->user()->associate($rep)->save();
						$commission->source()->associate($descendant)->save();
						//\Log::info($descendant->last_name.", ".$descendant->first_name." - Level:Infinity - Amount:".$infinity_value." ");
						$infinity_amount += $infinity_value;
						break;
				}
			}
		}

		$response['sum'] = $sum;
		$response['infinity'] = $infinity;
		$response['infinity_amount'] = $infinity_amount;
		//$response['dist'] = $distributions;
		$response['total_commission_earned'] = $response['infinity_amount'] + $response['sum'];
		$response['rep'] = User::find($repId);
		return $response;
	}

	/**
	* 
	*
	* @param  
	* @return int $count all updated reps
	*/
	public function infinity($repId)
	{
		$distribution =array();
		$rep = User::find($repId);
		if($rep->free_service) return $distribution;
		\Cache::forget('user_'.$repId.'_ancestors');

		$ancestors = $rep->ancestors;
		//return $ancestors;
		$total_available = 0;

		foreach($ancestors as $ancestor)
		{
			if($ancestor->rank_id >= 5)
			{
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
		return $distribution;
	}
}
?>
