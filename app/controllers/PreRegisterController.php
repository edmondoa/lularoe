<?php
use LLR\Payments\CMSPayment;
class PreRegisterController extends \BaseController {



	/**
	 * Show the form for creating a new preregister
	 *
	 * @return Response
	 */
	public function create($public_id = '')
	{
		//return dd($public_id);
		if (empty($public_id)) return View::make('pre-register.sponsor');
		$sponsor = User::where('public_id',$public_id)->first();
		if($sponsor->disabled)
		{
			return View::make('pre-register.sponsor')->with('message_danger', 'The sponsor you entered has been disabled');
		}
		//echo"<pre>"; print_r($sponsor); echo"</pre>";
		//exit;
		//return $sponsor;
		if(isset($sponsor->id))
		{
			return View::make('pre-register.create',compact('sponsor'));
		}
		else
		{
			return View::make('pre-register.sponsor')->with('message_danger', 'Missing or incorrect sponsor ID');
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
		$data = Input::all();
		$sponsor_id = $data['sponsor_id'];
		return Redirect::to('/join/' . $sponsor_id);
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
		$rules['card_number'] = 'required|numeric|digits_between:13,17';
		$rules['security'] = 'required|numeric|digits_between:3,4';
		$rules['expires_year'] = 'required|digits:4';
		$rules['expires_month'] = 'required|digits:2';
		//$rules['refund_policy'] = 'required|accepted';
		$rules['agree'] = 'required|accepted';
		$rules['password'] = 'required|confirmed|digits_between:8,32';
		$rules['public_id'] = 'required|unique:users,public_id';
		$rules['email'] = 'required|unique:users,email';
		$rules['sponsor_id'] = 'required';
		$validator = Validator::make($data = Input::all(), $rules);
		//echo"<pre>"; print_r($data); echo"</pre>";
		//echo"<pre>"; print_r('passed muster'); echo"</pre>";
		//exit;

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$data['amount'] = Config::get('site.preregistration_fee');
		$data['details'] = "Pre-registration";
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
				"amount" => $data['amount'],  //  ***Required*** integer
				"comments" => "",  // text
				"description" => $data['details'],  // text 
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
		$cmspayment = new CMSPayment();
		//exit;
		$cmspayment->create_request($params);
		//echo"<pre>"; print_r($data); echo"</pre>";
		//echo"<pre>"; print_r($user); echo"</pre>";
		//echo"<pre>"; print_r($address); echo"</pre>";
		//echo"<pre>"; print_r($event); echo"</pre>";
		//$cmspayment->expose($data);
		//exit;
		//exit;
		if($cmspayment->send_request())
		{
			$data['dob'] = date('Y-m-d',strtotime($data['dob']));
			$data['password'] = \Hash::make($data['password']);
			$user = User::create($data);

			//now the address
			$address = [
				'address_1'=>$data['address_1'],
				'address_2'=>$data['address_2'],
				'city'=>$data['city'],
				'state'=>$data['state'],
				'zip'=>$data['zip'],

			];
			$address = Address::create($address);
			$user->addresses()->save($address);
			//$user->addresses()->save($address);

			$data['transaction_id'] = $cmspayment->transaction_id;
			$data['details'] = '';
			$data['tender'] = 'Credit Card';
			$new_payment = Payment::create($data);
			
			$new_payment->user()->associate($user);
			//associate the payment to the new user
			$new_payment->save();

			$role = Role::where('name','Rep')->first();
			//echo"<pre>"; print_r($role); echo"</pre>";
			$user->role()->associate($role);
			$user->save();
			//exit('we got to here');
		}
		else
		{
			$errors = $cmspayment->errors_public;
			foreach($errors as $key => $error)
			{
				$validator->getMessageBag()->add($key, $error);
			}
			return Redirect::back()->withErrors($validator)->withInput();
		}
		//User::create($data);
		//exit;
		$userSite = UserSite::firstOrNew(['user_id'=> $user->id]);
		$user->userSite()->associate($userSite);
		Event::fire('rep.create', array('rep_id' => $user->id));
		Auth::loginUsingId($user->id);
		return Redirect::to('/dashboard');
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
