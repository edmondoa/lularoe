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
		$rules['terms_policy'] = 'required|accepted';
		$rules['password'] = 'required|confirmed|digits_between:8,32';

		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		echo"<pre>"; print_r('passed muster'); echo"</pre>";
		exit;
		User::create($data);

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
