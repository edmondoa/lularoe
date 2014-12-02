<?php

class MailMessagesController extends \BaseController {

	/**
	 * Display a listing of mailmessages
	 *
	 * @return Response
	 */
	public function index()
	{
		$mailmessages = Mailmessage::all();

		return View::make('mailmessages.index', compact('mailmessages'));
	}

	/**
	 * Show the form for creating a new mailmessage
	 *
	 * @return Response
	 */
	public function create($customerId)
	{
		$customer = Customer::findOrFail($customerId);
		return View::make('mailmessages.create',compact('customer'));
	}

	/**
	 * Store a newly created mailmessage in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$form_data = Input::all();
		//echo"<pre>"; print_r($form_data); echo"</pre>";
		//exit;
		$validator = Validator::make($form_data, Mailmessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$person = Person::find($form_data['customer_id']);
		if(!$person->hasMerchant(Auth::user()->merchant_id))
		{
			return Redirect::back()->with('message','Unable to send email at this time.');
		}
		//echo"<pre>"; print_r($customers); echo"</pre>";
		//exit;
		$merchant = Merchant::findOrFail(Auth::user()->merchant_id);
		$data['person'] = $person->toArray();
		$data['body'] = $form_data['message'];
		//echo"<pre>"; print_r($form_data); echo"</pre>";
		//echo"<pre>"; print_r($person->email); echo"</pre>";
		//echo"<pre>"; print_r($merchant->email_address); echo"</pre>";
		//continue;

		$result = Mail::send('emails.merchant.standard', $data , function($message) use($person,$merchant,$form_data)
		{
		    $message->to($person->email, $person->first.' '.$person->last)->subject($form_data['subject_line']);
		    if(!empty($merchant->email_address))
		    {
		    	$message->from($merchant->email_address, $merchant->name);
		    }
		    else
		    {
		    	$message->from('no-reply@sociallymobile.com', $merchant->name);
		    }
		});
		//exit;
		//Mailmessage::create($data);
		return Redirect::route('merchants.customers.show',[Auth::user()->merchant_id,$person->id])->with('message','Your message has been sent.');

		if($result)
		{
		}
		else
		{
			return Redirect::back()->with('message','Unable to send email at this time. Mail server is misbehaving!');
		}
		
	}

	/**
	 * Display the specified mailmessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$mailmessage = Mailmessage::findOrFail($id);

		return View::make('mailmessages.show', compact('mailmessage'));
	}

	/**
	 * Show the form for editing the specified mailmessage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$mailmessage = Mailmessage::find($id);

		return View::make('mailmessages.edit', compact('mailmessage'));
	}

	/**
	 * Update the specified mailmessage in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$mailmessage = Mailmessage::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Mailmessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$mailmessage->update($data);

		return Redirect::route('mailmessages.index');
	}

	/**
	 * Remove the specified mailmessage from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Mailmessage::destroy($id);

		return Redirect::route('mailmessages.index');
	}

}
