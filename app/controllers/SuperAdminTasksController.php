<?php

class SuperAdminTasksController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /superadmintasks
	 *
	 * @return Response
	 */
	public function getUpdateUserCreatedAt()
	{
		set_time_limit (120);
		DB::connection()->disableQueryLog();
		$reps = User::with('role','addresses')->where('created_at','0000-00-00 00:00:00')->get();
		//return $reps;
		foreach($reps as $rep)
		{
			$rep->timestamps = false;
			if(isset($rep->addresses[0]))
			{
				//echo "addresses";
				$rep->created_at = $rep->addresses[0]->created_at;
				$rep->save();
			}
			elseif(isset($rep->role))
			{
				//echo"roles";
				$rep->created_at = $rep->role->created_at;
				$rep->save();
			}
			//return $rep->role;
			else
			{
				$unrepairable_reps[] = $rep;
				//echo "Unable to update created_at date for ".$rep->first_name." ".$rep->last_name." - <br />\r\n";
			}
		}
		return $unrepairable_reps;
	}



}