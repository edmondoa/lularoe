<?php

class DevelopController extends \BaseController {

	/**
	 * Method for active development.
	 * GET /dev/test-speed
	 *
	 * @return Response
	 */
	public function getTestSpeed()
	{
		$start = microtime (true);
		$response['result'] = '';
		//$response['result'] = 
		$response['lapsed'] = round((microtime (true) - $start),5);
		return $response;
	}

	/**
	 * Method for active development.
	 * GET /dev/another
	 *
	 * @return Response
	 */
	public function getAnother()
	{
		//return Session::get('salt');
		$mwl_user = App::make('ExternalAuthController')->getMwlUserInfo(9851);
		return Response::json($mwl_user);
		exit;
	}

	/**
	 * Method for active development.
	 * GET /dev/jake
	 *
	 * @return Response
	 */
	public function getJake()
	{
        //return Hash::make('password2');
        //return Auth::user();
        $userId = 9934;
		//query to get payments
		$sql = "
			SELECT 
				payments.id,
				ROUND(SUM(payments.amount), 2) as amount,
				payments.created_at
			FROM users 
			INNER JOIN tid ON (tid.id=users.id) 
			INNER JOIN accounts ON (accounts.id=tid.account) 
			LEFT JOIN payments ON (payments.account=accounts.id) 
			WHERE users.username=".$userId." AND batchedIn = -1 
			GROUP BY payments.id
			ORDER BY payments.created_at
		";
		//query to get transactions in payment
		$payment_id = 84058;
		$sql = "
			SELECT 
				transaction,
				payments.id,
				ROUND(payments.amount, 2) as amount,
				payments.created_at
			FROM users 
			INNER JOIN tid ON (tid.id=users.id) 
			INNER JOIN accounts ON (accounts.id=tid.account) 
			LEFT JOIN payments ON (payments.account=accounts.id) 
			WHERE users.username=".$userId." AND batchedIn = ".$payment_id."
			ORDER BY payments.created_at
		";
		// /AND created_at >= '{Start_Date}' AND created_at <= '{End_Date}'
        $data = DB::connection('mysql-mwl')->select($sql);
        return $data;

		return App::make('ExternalAuthController')->getMwlUserInfo(Auth::user()->id);
		return "done";
		return App::make('ExternalAuthController')->updateMwlUser(1234);
		exit('something');
		return App::make('ExternalAuthController')->createMwlUser(10095);
		exit;
		return "<a href='http://llr.local/sendonboardemail/9851'>Here</a>";
		//echo "<img src='".DNS1D::getBarcodePNGPath("123456789", "EAN13",3,150)."' >";
		//exit;
		$start = microtime (true);
		$response['result'] = Hash::make('password2');
		//$response['result'] = User::find(9921)->descendants()->orderBy('pivot_level')->get();
		//return Product::all();
/*		foreach(Product::all() as $product)
		{
			echo"<p><strong>".$product->name." - ".$product->sku."</strong><br />";
			//$path = DNS1D::getBarcodePNGPath($product->sku, "C128",3,75);
			echo "<img src='".$product->barcode_image."' ></p>";
			//$product->barcode_image=$path;
			//$product->save();
		}
*/		//$response['result'] = User::find(9921)->ranks()->first();
		$response['lapsed'] = round((microtime (true) - $start),5);
		return $response;
		//return Rank::all();
		$rep = User::find(1);
		$count = 1;
		//return $rep;
		foreach($rep->personally_sponsored()->get() as $frontline)
		{
			$stats = $frontline->stats()->where('userstats.commission_period',date('Y-m-00'))->first();
			if($stats->personal_points_volume >= 3500)
			{
				$stats->qualified = true;
				//echo"<pre>"; print_r($stats); echo"</pre>";
			}
			else
			{
				$stats->qualified = false;
				//echo"not this one: <br />";
			}
		}
		$response['result'][] = DB::getQueryLog();
		$response['lapsed'] = round((microtime (true) - $start),5);
		return $response;
		exit;
		return User::find(1); //->ranks;
	}

	/**
	 * Method for active development.
	 * GET /dev/commission
	 *
	 * @return Response
	 */
	public function getCommission()
	{
		set_time_limit(300);
		$start = microtime (true);
		$response['result'] = Commission::runCommissions(date('Y-m-d',strtotime('last month')));
		//$response['result'] = Rank::all();
		//User::find(2001)->clearUserCache();
		
/*		
		$commission = new \LLR\Commission\Commission;
		$commission->setCommissionPeriod(date('Y-m-d'));
		//$commission->setCommissionPeriod(date('Y-m-d'));
		$response['result'] = $commission->calculate(9921);
*/
		//$rep = User::find(2001)->descendants;
		//$user = User::find(0);
		//$user->clearUserCache();
		//$response['result'] = User::find(0)->descendants;
		//$response['result'] = Commission::setUserStats(1201,date('Y-m-d',strtotime('last month')));
		//$response['result'] = Commission::setAllUserStats(date('Y-m-d',strtotime('last month')));
		//$response['result'] = Commission::setAllUserStats(date('Y-m-d'));
		//$response['result'] = Commission::updateRanks(date('Y-m-d',strtotime('last month')));
		//$response['result'] = Commission::setAllFreeService();
		//$response['result'] = User::where('free_service',1)->get();
		//$response['result'] = User::find(2001)->descendants_sm()->get();
		
		//$response['result'] = Commission::calculate(2001);
		//$response['lapsed'] = round((microtime (true) - $start),5);
		//return Response::json($response);
		//return $rep;
		//set_time_limit(300);
		//$response['result'] = User::take(4000)->get(['id','first_name','last_name']);
		//$response['result'] = DB::table('users')->get(['id','first_name','last_name']);
		//Commission::setUserStats($rep->id);
		//$response['result'] = DB::table('users')->take(25000)->get(['id']);
		//$response['result'] = User::take(10000)->get(['id']);
		//$response['result'] = User::where('free_service',true)->get();
		//$response['result'] = User::find(2001);
	/*	foreach(User::take(4000)->get(['id']) as $rep)
		{
			Commission::free_service($rep->id);
		}
	*/	/*
		foreach(User::orderByRaw("RAND()")->take(100)->get() as $rep)
		{
			SociallyMobile::addDownline($rep->id);
		}
		*/
		//$response['result'] = Commission::free_service(2001);
		//$response['result'] = User::find(2001)->plans;
/*		$response['lapsed'] = round((microtime (true) - $start),5);
		return $response;
		exit;
		return User::take(150)->remember(1,'first125')->get();

		$start = microtime (true);
		$response['result'] = Commission::infinity(2024);
		//$response['result'] = User::find(2024)->ancestors()->whereNotNull('users.sponsor_id')->get();
		$response['lapsed'] = round((microtime (true) - $start),5);
		return $response;
*/
		##############################################################################################
		# loading commission non-statically
		##############################################################################################
		
		//$commission = new \LLR\Commission\Commission;
		//$commission->setCommissionPeriod(date('Y-m-d',strtotime('last month')));
		//$response['result'] = $commission->setRank(0,true);
		$response['lapsed'] = round((microtime (true) - $start),5);
		return Response::json($response);
	}


	/**
	 * Method for active development.
	 * GET /dev/start
	 *
	 * @return Response
	 */
	public function getStart()
	{
		//
	}

}
?>