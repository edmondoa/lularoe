<?php

Event::listen('illuminate.query', function($query){
	//\Log::info($query);
	// /echo""; print_r($query); echo"\r\n";
});

Event::listen('rep.create' , function($rep_id)
{
	return Commission::level_up($rep_id);
	User::find($rep_id)->clearUserCache();
	foreach(User::find($rep_id)->ancestors as $rep)
	{
		$rep->clearUserCache();
	}
	$user = User::find($rep_id);
});

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
