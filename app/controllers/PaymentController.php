<?php
use Eventz\Payments\USAEpayment;
class PaymentController extends \BaseController {

	/**
	 * Display a listing of payments
	 *
	 * @return Response
	 */
	public function index()
	{
		$payments = Payment::all();

		return View::make('payment.index', compact('payments'));
	}

	/**
	 * Show the form for registering for an event
	 *
	 * @return Response
	 */
	public function register($id)
	{
		$event = Uvent::findOrFail($id);
		$divisions = Division::where('uvent_id', $id)->orderBy('name', 'ASC')->lists('name','id');
		$teams = Team::where('uvent_id', $id)->orderBy('team_name', 'ASC')->get();
		$shirts = Uvent::find($id)->shirts()->get();
		return View::make('payment.register', compact('event', 'divisions', 'teams', 'shirts'));
	}
	
	/**
	 * Show the form for creating a new sign-up and payment
	 *
	 * @return Response
	 */
	public function signUp()
	{
		return View::make('payment.sign-up', compact('event','data'));
	}

	/**
	 * Show the form for creating a new payment
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//echo"<pre>"; print_r(Input::all()); echo"</pre>";
		//exit;

		$rules = [
			'ticket_type' => 'required',
			'division_id' => 'required_without_all:team_id,team_captain',
			'team_name' => 'required_with:team_captain',
			'team_id' => 'required_without_all:division_id,team_captain',
		];
		$validator = Validator::make($data = Input::all(),$rules);

		if ($validator->fails())
		{
			//return Redirect::to('register')->withErrors($validator)->withInput();
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$event = Uvent::findOrFail($id);
		if($data['ticket_type'] == 'individual')
		{
			$data['sub_total'] = $event->ticket_single_price + Config::get('site.athlete_fee');
		}
		elseif($data['ticket_type'] == 'team')
		{
			$data['sub_total'] = $event->ticket_team_price + Config::get('site.athlete_fee');
		}
		else
		{
			//return Redirect::to('register')->with('message','An unknown error ocurred')->withInput();
		}
		$data['total'] = /*$data['tax']+*/$data['sub_total'];
		
		//$info = Input::all();
		return View::make('payment.create', compact('event','data'));
	}

	/**
	 * Store a newly created payment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		//echo"<pre>"; print_r($data); echo"</pre>";
		//$division = Division::find($data['division_id']);
		//echo"<pre>"; print_r($division); echo"</pre>";
		//exit;
		$user = User::findOrFail(Auth::user()->id);
		$address = User::findOrFail(Auth::user()->id)->addresses->first();
		$event = Uvent::findOrFail($data['event_id']);
		$validator = Validator::make($data, array(
			'amount' => 'required|numeric',
			'card_number'=> 'required|digits_between:13,17',
			'security' => 'required|digits_between:3,4',
			'expires_year' => 'required',
			'expires_month' => 'required',
			'refund_policy' => 'required',
			//'zip' => 'required'
		));


		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$validator_array = (array) $validator;
		//echo"<pre>"; print_r($validator_array); echo"</pre>";
		
		$params = array(
			"command" => "sale",
			"type" => 'CreditCard', //Name of the account holder.
			"account_holder" => $user->first_name." ".$user->last_name, //Name of the account holder.
			"customer_id" => $user->id,
			"billing_address" => array(
				"first_name" => $user->first_name,
				"last_name" => $user->last_name,
				"email" => $user->email,
				//"company" => "",
				"street_1" => $address['address'],
				"street_2" => $address['address2'],
				"city" => $address['city'],
				"state" => $address['state'],
				"zip" => $address['zip']
			), //address object or add later
			"software" => "BOX.EVENTS", 
			//"recurring_billing" => array(), //recurring billing object or add later
			"details" => array(
				"amount" => $data['amount'],  //  ***Required*** integer
				"comments" => "",  // text
				"description" => '',  // text 
			), 
			"credit_card_data" => array(
				"type" => 'CreditCard',
				"card_number" => $data['card_number'],
				"card_code" => $data['security'],
				"card_exp" => $data['expires_month'].$data['expires_year'],
				"card_street" => $address['address'],
				"card_zip" => $address['zip'],
			), //credit card payment object or add later
			//"check_data" => array(), //e-check payment object or add later
		);

		$payment = new USAEpayment();
		//exit;
		$payment->create_request($params);
		//echo"<pre>"; print_r($data); echo"</pre>";
		//echo"<pre>"; print_r($user); echo"</pre>";
		//echo"<pre>"; print_r($address); echo"</pre>";
		//echo"<pre>"; print_r($event); echo"</pre>";
		//$payment->expose($data);
		//exit;
		//exit;
		if($payment->send_request())
		{
			//$payment->expose($data);
			// clean up our data
			//exit;
			$data['transaction_id'] = $payment->transaction_id;
			$data['details'] = '';
			$data['tender'] = 'CreditCard';
			$new_payment = Payment::create($data);
			$new_payment->event()->associate($event);
			$new_payment->user()->associate(Auth::user());
			$new_payment->save();
			//now check for a new team
			if(($data['team_captain'] == 'on')&&(!empty($data['team_name'])))
			{
				//create the new team
				//$captain = 
				$team = Team::create([
					'team_name' => $data['team_name']
				]);
				$team->captain()->associate(Auth::user());
				$team->event()->associate($event);
				$team->save();
				$new_payment->team()->associate($team);
				$team->members()->attach(Auth::user());
			}
			elseif(!empty($data['team_id']))
			{
				$team = Team::find($data['team_id']);
				$new_payment->team()->associate($team);
				$team->members()->attach(Auth::user());
			}

			//now if division is set assciate it to a division
			if(!empty($data['division_id']))
			{
				$division = Division::find($data['division_id']);
				$new_payment->division()->associate($division);
			}
			if(!empty($data['shirt_id']))
			{
				$shirt = Shirt::find($data['shirt_id']);
				$new_payment->shirts()->associate($shirt);
			}
			$new_payment->save();
			$role = Role::where('name','Athlete')->first();
			//echo"<pre>"; print_r($role); echo"</pre>";
		    $event->roles()->attach(Auth::user(),array('role_id' => $role->id));

			//exit('we got to here');
			return Redirect::route('dashboard')->with('message',"Success: Your payment has been received.");
		}
		else
		{
			$errors = $payment->errors_public;
			foreach($errors as $key => $error)
			{
				$validator->getMessageBag()->add($key, $error);
			}
			return Redirect::back()->withErrors($validator)->withInput();
		}
	}

	/**
	 * Display the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$payment = Payment::findOrFail($id);

		return View::make('payment.show', compact('payment'));
	}

	/**
	 * Show the form for editing the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$payment = Payment::find($id);

		return View::make('payment.edit', compact('payment'));
	}

	/**
	 * Update the specified payment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$payment = Payment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Payment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$payment->update($data);

		return Redirect::route('payment.index');
	}

	/**
	 * Remove the specified payment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Payment::destroy($id);

		return Redirect::route('payment.index');
	}

}
