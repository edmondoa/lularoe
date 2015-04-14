<?php

class SaleController extends \BaseController {


	public function checkout() {
		return View::make('inventory.checkout');
	}

	/**
	 * Display a listing of sales
	 *
	 * @return Response
	 */
	public function index()
	{
        Session::forget('discount');
        Session::forget('paidout');
        Session::forget('emailto');
        Session::forget('repsale');
        Session::forget('orderdata');
        Session::forget('subtotal');
        Session::forget('customdiscount');
        Session::forget('tax');
        Session::forget('paidout');
        Session::forget('payments');
        Session::forget('paymentdata');

		Session::put('repsale',true);
		//$sales = Sale::all();

		return View::make('sale.index');
	}

	public function consignmentsale($repid)
	{
		Session::put('repsale', false);
		$user = User::where('id','=',$repid)->first();
		return View::make('sale.consignmentsale',compact('user'));
	}

	public function consignmentpurchase()
	{
		die('GOT HERE');
	}

	/**
	 * Show the form for creating a new sale
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check()) $user = Auth::user();
		$billing_address = Address::where('addressable_type', 'User')->where('addressable_id', $user->id)->where('label', 'Billing')->get()->first();
		$shipping_address = Address::where('addressable_type', 'User')->where('addressable_id', $user->id)->where('label', 'Shipping')->get()->first();
		if (!isset($billing_address)) {
			$billing_address = [
				'address_1' => '',
				'address_2' => '',
				'city' => '',
				'state' => '',
				'zip' => '',
			];
		}
		if (!isset($shipping_address)) {
			$shipping_address = [
				'address_1' => '',
				'address_2' => '',
				'city' => '',
				'state' => '',
				'zip' => '',
			];
		}
		$subtotal = 0;
		foreach(Session::get('products') as $product) {
			if (Session::get('party_id') != null) $price = $product->rep_price;
			else $price = $product->price;
			$subtotal += ($price * $product->purchase_quantity);
		}
		$tax = Config::get('site.tax') * $subtotal;
		$shipping = Config::get('site.shipping');
		$total = $subtotal + $tax + $shipping;
		// echo '<pre>'; print_r($billing_address); echo '</pre>';
		// exit;
		return View::make('sale.create', compact('subtotal', 'tax', 'shipping', 'total', 'user', 'billing_address', 'shipping_address'));
	}

	/**
	 * Store a newly created sale in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = User::$rules;
		$rules['address_1'] = 'required|between:2,28';
		$rules['city'] = 'required';
		$rules['state'] = 'required|size:2';
		$rules['zip'] = ['required','numeric','regex:/(^\d{5}$)|(^\d{5}-\d{4}$)/'];
		$rules['card_number'] = 'required|numeric|digits_between:13,17';
		$rules['security'] = 'required|numeric|digits_between:3,4';
		$rules['expires_year'] = 'required|digits:4';
		$rules['expires_month'] = 'required|digits:2';
		$rules['email'] = 'required|unique:users,email';
		$validator = Validator::make($data = Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$data['details'] = [];
		foreach (Session::get('products') as $product) {
			$data['details'][] = $product->purchase_quantity . ' &times; ' . $product->name;
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
			// $data['dob'] = date('Y-m-d',strtotime($data['dob']));
			// $data['password'] = \Hash::make($data['password']);
			// $user = User::create($data);

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
	 * Display the specified sale.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sale = Sale::findOrFail($id);

		return View::make('sale.show', compact('sale'));
	}

	/**
	 * Show the form for editing the specified sale.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sale = Sale::find($id);

		return View::make('sale.edit', compact('sale'));
	}

	/**
	 * Update the specified sale in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sale = Sale::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Sale::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$sale->update($data);

		return Redirect::route('sales.show', $id)->with('message', 'Sale updated.');
	}

	/**
	 * Remove the specified sale from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Sale::destroy($id);

		return Redirect::route('sales.index')->with('message', 'Sale deleted.');
	}
	
	/**
	 * Remove sales.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Sale::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('sales.index')->with('message', 'Sales deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Sale deleted.');
		}
	}
	
	/**
	 * Diable sales.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Sale::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('sales.index')->with('message', 'Sales disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Sale disabled.');
		}
	}
	
	/**
	 * Enable sales.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Sale::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('sales.index')->with('message', 'Sales enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Sale enabled.');
		}
	}

}
