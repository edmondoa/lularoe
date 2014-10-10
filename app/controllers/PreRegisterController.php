<?php
use SociallyMobile\Payments\USAEpayment;
class PreRegisterController extends \BaseController {



	/**
	 * Show the form for creating a new preregister
	 *
	 * @return Response
	 */
	public function create($public_id)
	{
		$sponsor = User::where('public_id',$public_id)->first();
		if(isset($sponsor->id))
		{
			return View::make('pre-register.create',compact('sponsor'));
		}
		else
		{
			return View::make('pre-register.sponsor')->with('error', 'Missing or incorrect sponsor ID');
		}
		//return View::make('pre-register.create');
	}

	/**
	 * Go to sponsor form if no sponsor_id is in the URL
	 *
	 * @return Response
	 */
	public function sponsor()
	{
		return View::make('pre-register.sponsor');
	}


	/**
	 * Redirect to create form upon entering sponsor_id
	 *
	 * @return Response
	 */
	public function redirect()
	{
		$sponsor_id = Input::only('sponsor_id');
		return Redirect::route('join/' . $sponsor_id);
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
		//$rules['refund_policy'] = 'required|accepted';
		$rules['agree'] = 'required|accepted';
		$rules['password'] = 'required|confirmed|digits_between:8,32';
		$rules['public_id'] = 'required|unique:users,public_id';
		$rules['email'] = 'required|unique:users,email';

		$validator = Validator::make($data = Input::all(), $rules);
		//echo"<pre>"; print_r($data); echo"</pre>";
		//echo"<pre>"; print_r('passed muster'); echo"</pre>";
		//exit;

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$params = array(
			"command" => "sale",
			"type" => 'CreditCard', //Name of the account holder.
			"account_holder" => $data['first_name']." ".$data['last_name'], //Name of the account holder.
			//"customer_id" => $user->id,
			"billing_address" => array(
				"first_name" => $data['first_name'],
				"last_name" => $data['last_name'],
				"email" => $data['email'],
				//"company" => "",
				"street_1" => $data['address_1'],
				"street_2" => $data['address_2'],
				"city" => $data['city'],
				"state" => $data['state'],
				"zip" => $data['zip']
			), //address object or add later
			"software" => "", 
			//"recurring_billing" => array(), //recurring billing object or add later
			"details" => array(
				//"amount" => $data['amount'],  //  ***Required*** integer
				"amount" => 100.00,  //  ***Required*** integer
				"comments" => "",  // text
				"description" => 'Pre-registration',  // text 
			), 
			"credit_card_data" => array(
				"type" => 'CreditCard',
				"card_number" => $data['card_number'],
				"card_code" => $data['security'],
				"card_exp" => $data['expires_month'].$data['expires_year'],
				"card_street" => $data['address_1'],
				"card_zip" => $data['zip'],
			), //credit card payment object or add later
			//"check_data" => array(), //e-check payment object or add later
		);
		//echo"<pre>"; print_r($params); echo"</pre>";
		//exit;
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
			$data['dob'] = date('Y-m-d',strtotime($data['dob']));
			$user = User::create($data);
			//$payment->expose($data);
			// clean up our data
			//exit;
			$data['transaction_id'] = $payment->transaction_id;
			$data['details'] = '';
			$data['tender'] = 'CreditCard';
			$new_payment = Payment::create($data);
			
			$new_payment->user()->associate($user);
			//associate the payment to the new user
			$new_payment->save();

			$role = Role::where('name','Rep')->first();
			//echo"<pre>"; print_r($role); echo"</pre>";
		    $user->role()->associate($role);

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
