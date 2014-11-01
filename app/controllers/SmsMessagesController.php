<?php

//use Duezee\Twilio\Twilio;

class SmsMessagesController extends \BaseController {

	/**
	 * Display a listing of smsmessages
	 *
	 * @return Response
	 */
	public function index()
	{
		$smsmessages = Smsmessage::all();

		return View::make('sms_messages.index', compact('smsmessages'));
	}

	/**
	 * Show the form for creating a new smsmessage
	 *
	 * @return Response
	 */
	public function create($phoneId)
	{

		$person = Phone::find($phoneId)->person;
		$phone = Phone::find($phoneId);
		return View::make('sms_messages.create',compact('person','phone'));
	}

	/**
	 * Store a newly created smsmessage in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		$rules = Smsmessage::$rules;
		$rules['phone_id'] = 'required';
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$phone = Phone::findOrFail($data['phone_id']);
		$person = Phone::findOrFail($data['phone_id'])->person;
		//$sender = Person::findOrFail(Auth::user()->person_id);
		$merchant = Merchant::findOrFail(Auth::user()->merchant_id);
		$from = $merchant->twilio_number;
		
		$response = Twilio::message($phone->phone_num, $data['message'],$from);

		$data['direction'] = 'out';
		$data['from_number'] = $response->from;
		$data['to_number'] = $response->to;
		$data['twilio_id'] = $response->sid;
		$data['status'] = 'Sent';
		$data['date_sent'] = date('Y-m-d H:i:s');
		$data['date_queued'] = date('Y-m-d H:i:s');

		//echo"<pre>"; print_r($response); echo"</pre>";
		//exit;
		$sms = Smsmessage::create($data);
		$sms->person()->associate($person);
		$sms->merchant()->associate($merchant);
		$sms->save();

		return Redirect::route('merchants.customers.show',[Auth::user()->merchant_id,$person->id]);
	}

	/**
	 * Display the specified smsmessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$smsmessage = Smsmessage::findOrFail($id);

		return View::make('sms_messages.show', compact('smsmessage'));
	}

	/**
	 * Show the form for editing the specified smsmessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$smsmessage = Smsmessage::find($id);

		return View::make('sms_messages.edit', compact('smsmessage'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$smsmessage = Smsmessage::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Smsmessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$smsmessage->update($data);

		return Redirect::route('sms_messages.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Smsmessage::destroy($id);

		return Redirect::route('sms_messages.index');
	}


}