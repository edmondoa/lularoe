<?php

class PreRegisterController extends \BaseController {



	/**
	 * Show the form for creating a new preregister
	 *
	 * @return Response
	 */
	public function create($public_id)
	{
		$sponsor = User::where('public_id','=',$public_id)->first();
		// echo"<pre>"; print_r($sponsor); echo"</pre>";
		// exit;
		if(isset($sponsor->id))
		{
			return View::make('pre-register.create',compact('sponsor'));
		}
		else
		{
			return 'Unknown Sponsor';
		}
		//return View::make('pre-register.create');
	}

	/**
	 * Store a newly created preregister in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//get the rules from the model
		$rules = User::$rules;
		//create som new ones for this form

		$rules['address_1'] = 'required|between:2,28';
		$rules['city'] = 'required';
		$rules['state'] = 'required|size:2';
		$rules['zip'] = ['required','numeric','regex:/(^\d{5}$)|(^\d{5}-\d{4}$)/'];
		$rules['dob'] = 'required|before:'.date('Y-m-d',strtotime('18 years ago'));
		$rules['card_number'] = 'required|numeric';
		$rules['security'] = 'required|numeric';
		$rules['expires_year'] = 'required|digits:4';
		$rules['expires_month'] = 'required|digits:2';
		$rules['refund_policy'] = 'required|accepted';
		$rules['agree'] = 'required|accepted';
		$rules['password'] = 'required|confirmed|digits_between:8,32';

		$validator = Validator::make($data = Input::all(), $rules);
		echo"<pre>"; print_r($data); echo"</pre>";
		echo"<pre>"; print_r('passed muster'); echo"</pre>";
		exit;

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$params = array(
			"command" => "sale",
			"type" => 'CreditCard', //Name of the account holder.
			"account_holder" => $data." ".$user->last_name, //Name of the account holder.
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
	    }
		//User::create($data);

		//return Redirect::route('pre-register.index');
	}

	/**
	 * Remove the specified preregister from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Preregister::destroy($id);

		return Redirect::route('pre-register.index');
	}

}
