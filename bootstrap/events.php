<?php

Event::listen('illuminate.query', function($query){
	
	//\Log::info($query);
	// /echo""; print_r($query); echo"\r\n";
/*	if(Session::has('queries'))
	{
		$saved_queries = Session::get('queries');
		//echo"<pre>"; print_r($saved_queries); echo"</pre>\r\n";
	}
	else
	{
		$saved_queries = [];
	}
	$saved_queries[] = $query;
	Session::flash('queries',$saved_queries);
	//dd(Session::get('queries'));
*/});
// bonuses
Event::listen('reps.rank' , function($rep_id)
{
	
	// assess percentages
	// determine rank
	// if rep is within 8 weeks of signup date || 8_in_8 == true
		// check if they have 8 customers
		$x_in_x = true;
	// else
		// check if they have 12 customers
		$x_in_x = true;
	// if x_in_x == true
		// free service bonus
			// grab 8/12 highest, take an average
			// subtract average from phone bill (minus tax)
		// instant action bonus
			// rep gets $40
			// parent gets $20
		// free in 3 advance
			// foreach child in downline
				// if x_in_x == true
				// x ++
				// (if $x == 3) continue
			if (x > 3 && x < 6)
			{
				// min_commission = 300
			}
			elseif (x >= 6) //free in 6 advance
			{
				// min_commission = 800
			}
	
	

	
	
});

// commissions
Event::listen('rep.commissions' , function($rep_id)
{
	// residual income
		// count downline by level
			// count rep_id & level
			// statement
				// line item
					// rep_id
					// date
					// amount
					// description
					// quantity
				
});

// infinity income
Event::listen('rep.commissions' , function($rep_id)
{
	// highest rank = '';
	// rep_value = '';
	// count;
	// get all downline
		// return rep_id and rep_rank
		// foreach reps as rep
			// count ++;
			// if (rank > Executive)
});
// infinity income
Event::listen('rep.create' , function($rep_id)
{
	return Commission::level_up($rep_id);
	User::find($rep_id)->clearUserCache();
	foreach(User::find($rep_id)->ancestors as $rep)
	{
		$rep->clearUserCache();
	}
});

// infinity income
Event::listen('rep.update' , function($rep_id)
{
	// return Commission::level_up($rep_id);
	// when a rep is updated, we need to clear some cached items
	// first the cached information for the current user
	User::find($rep_id)->clearUserCache();
	foreach(User::find($rep_id)->ancestors as $rep)
	{
		$rep->clearUserCache();
	}
});

// infinity income
Event::listen('sponsor.update' , function($rep_id)
{
	Commission::delete_levels_down($rep_id);
	Commission::set_levels_down($rep_id);
	User::find($rep_id)->clearUserCache();
	foreach(User::find($rep_id)->ancestors as $rep)
	{
		$rep->clearUserCache();
	}
});
