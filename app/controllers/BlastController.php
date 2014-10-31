<?php

class BlastController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /blast
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /blast/create
	 *
	 * @return Response
	 */
	public function CreateSms()
	{
		$users = User::whereIn('id', Input::get('user_ids'))->get();
		return View::make('blasts.createsms', compact('users'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /blast
	 *
	 * @return Response
	 */
	public function StoreSms()
	{
		$data = Input::all();
		 $rules = [
			'message' => 'required|min:5',
			'user_ids'=> 'required'
		];
		$validator = Validator::make($data = Input::all(),$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		//echo"<pre>"; print_r($data); echo"</pre>";
		//exit;

		$users = User::whereIn('id', $data['user_ids'])->get();
		//$merchant = Merchant::findOrFail(Auth::user()->merchant_id);
		$count = 0;
		$not_textable = 0;
		foreach($users as $user)
		{
			//echo"<pre>"; print_r($user->toArray()); echo"</pre>";
			//continue;
			if(!SociallyMobile::check_for_mobile($user->phone))
			{
				if(empty($user->phone_sms))
				{
					$user->phone_sms = false;
					$user->save();
				}
				$not_textable ++;
				continue;
			}
			else
			{
				$user->phone_sms = true;
				$user->save();
			}
			if(!$user->phone_sms)
			{
				$not_textable ++;
				continue;
			}
			if(empty($user->phone_sms))
			{
				$user->phone_sms = true;
				$user->save();
			}
			//echo'<h2>This is a mobile number</h2>';
			//echo"<p>Text sent to ".$user->phone."</p>";
			$count ++;
			//continue;
			$response = Twilio::message($user->phone, $data['message']);
			//if($response)
			$data['direction'] = 'out';
			$data['from_number'] = $response->from;
			$data['to_number'] = $response->to;
			$data['twilio_id'] = $response->sid;
			$data['status'] = 'Sent';
			$data['date_sent'] = date('Y-m-d H:i:s');
			$data['date_queued'] = date('Y-m-d H:i:s');

			$sms = Smsmessage::create($data);
			$sms->recipient()->associate($user);
			$sms->sender()->associate(Auth::user());
			$sms->save();
			sleep(1);
		}
		//echo"<pre>"; print_r($users->toArray()); echo"</pre>";
		//exit;
		return Redirect::back()->with('message','The text message was sent successfully to '.$count.' recipients. Unable to send message to '.$not_textable.' recipients because they have no textable phone on file.');

	}

	public function CreateMail()
	{
		$users = User::whereIn('id', Input::get('user_ids'))->get();
		return View::make('blasts.createmail', compact('users'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /blast
	 *
	 * @return Response
	 */
	public function StoreMail()
	{
		$form_data = Input::all();
		$rules = [
			'user_ids' => 'required',
			'body' => 'required',
			'subject_line' => 'required',
		];
		$validator = Validator::make($form_data,$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$users = User::whereIn('id', $form_data['user_ids'])->get();
		//echo"<pre>"; print_r($users->toArray()); echo"</pre>";
		//exit;
		$count = 0;
		foreach($users as $user)
		{
			$data['user'] = $user->toArray();
			$data['body'] = $form_data['body'];

			Mail::send('emails.standard', $data , function($body) use($user,$form_data)
			{
				$body->to($user->email, $user->first_name.' '.$user->last_name)->subject($form_data['subject_line']);
				$body->from(Auth::user()->email, Auth::user()->first_name . ' ' . Auth::user()->last_name);
			});
			$count ++;
		}
		if(count(Mail::failures()) > 0)
		{
			//errors ocurred
			return Redirect::back()->with('message','The email message was sent successfully to '. $count .' users');
		}
		else
		{
			return Redirect::back()->with('message','The email message was sent successfully to '. $count .' users');
		}
		//return Redirect::back()->with('message','The email message was sent successfully to '. $count .' users');

	}

	/**
	 * Display the specified resource.
	 * GET /blast/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /blast/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /blast/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /blast/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}