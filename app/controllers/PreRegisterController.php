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
		if (empty($public_id)) return View::make('pre-register.sponsor');
		$sponsor = User::where('public_id',$public_id)->first();
		if (!isset($sponsor->id)) return View::make('pre-register.sponsor')->with('message_danger', 'Missing or incorrect sponsor ID');
		
		if($sponsor->disabled)
		{
			return View::make('pre-register.sponsor')->with('message_danger', 'The sponsor you entered has been disabled');
		}
		return View::make('pre-register.create',compact('sponsor'));
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
		$rules = [];
		// $rules['address_1'] = 'required|between:2,28';
		// $rules['city'] = 'required';
		// $rules['state'] = 'required|size:2';
		// $rules['zip'] = ['required','numeric','regex:/(^\d{5}$)|(^\d{5}-\d{4}$)/'];
		$rules['dob'] = 'required|before:'.date('Y-m-d',strtotime('18 years ago'));
		$rules['agree'] = 'required|accepted';
		// $rules['password'] = 'required|confirmed|between:8,32';
		$rules['public_id'] = 'required|unique:users,public_id';
		$rules['email'] = 'required|unique:users,email';
		$rules['phone'] = 'required|numeric:between:10,12';
		$rules['sponsor_id'] = 'required';
		$data = Input::all();
		formatPhone($data['phone']);
		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$data['dob'] = date('Y-m-d',strtotime($data['dob']));
		// $data['password'] = \Hash::make($data['password']);
		$user = User::create($data);
		
		//now the address
		// $address = [
			// 'address_1'=>$data['address_1'],
			// 'address_2'=>$data['address_2'],
			// 'city'=>$data['city'],
			// 'state'=>$data['state'],
			// 'zip'=>$data['zip'],
			// 'label'=>'Billing',
		// ];
		// $address = Address::create($address);
		// $user->addresses()->save($address);
		
		$role = Role::where('name','Rep')->first();
		//echo"<pre>"; print_r($role); echo"</pre>";
		$user->role()->associate($role);
		$user->hasSignUp = 0;
		$user->save();
		
		//User::create($data);
		//exit;
		$userSite = UserSite::firstOrNew(['user_id'=> $user->id]);
		$user->userSite()->associate($userSite);
		Event::fire('rep.create', array('rep_id' => $user->id));
		#$loginuser = Auth::loginUsingId($user->id);
		
		// Used to create verification link
		$userid		= $user->id;
		$sponsorid	= $user->sponsor_id;
		$dob		= $user->dob;
		$public_id	= $user->public_id;
		$email		= $user->email;
		
		$sponsor = User::where('id',$sponsorid)->first();
		Session::put('sponsor',$sponsor);
		
		$hash = sha1(sha1($userid).sha1($dob).sha1($sponsorid));
		$verification_link = 'http://'.Config::get('site.domain').'/u/'.$userid.'-'.$hash; 
		
		Mail::send('emails.verification', compact('verification_link', 'user'), function($message) use(&$user)
		{
			$message->to($user->email, $user->first_name.' '.$user->last_name)->subject('Verify Your Email Address');
		});
		
		return Redirect::to('/pending-registration');
	}

	public function updatebankinfo() {
		foreach(Input::get() as $kvp) {
			$data[$kvp['name']] = $kvp['value'];
		}

		$data['user_id'] = Auth::user()->id;
		Bankinfo::create($data);

		$status = 'success';
		$message = 'Bank info created';
		return Response::json(['status'=>$status,'message'=>$message,'next_page'=>'shipping_address']);
	}

	public function shippingAddress() {
		$user = User::find(Auth::user()->id);
		$request = Request::instance();
		parse_str($request->getContent(), $data);

		$rules = [];
		$rules['address_1'] = 'required|between:2,28';
		$rules['city'] = 'required';
		$rules['state'] = 'required|size:2';
		$rules['zip'] = ['required','numeric','regex:/(^\d{5}$)|(^\d{5}-\d{4}$)/'];

		// Set shipping same as billing
		if (isset($data['shippingsameasbilling'])) {
			$data['addresses'][2] = $data['addresses'][1];
			$data['addresses'][2]['label'] = 'Shipping';
		}
		
		foreach($data['addresses'] as $address) {
			$validator = Validator::make($address, $rules);
			if ($validator->fails())
			{
				$status = 'error';
				$message = 'One or more of your adddress fields is invalid.';
			}
			else {
				$add = new Address();
				$add->address_1	= $address['address_1'];
				$add->address_2	= $address['address_2'];
				$add->city		= $address['city'];
				$add->state		= $address['state'];
				$add->zip		= $address['zip'];

				$user->addresses()->save($add);
				$status = 'success';
				$message = 'Addresses Saved';
			}
		}
		if (Session::get('pre-register.status') == 'existingRep')
			return Response::json(['status'=>$status,'message'=>$message,'next_page'=>'products']);
		else
			return Response::json(['status'=>$status,'message'=>$message,'next_page'=>'call_in']);
	}

	public function pending(){
		$sponsor = Session::get('sponsor');
		if(empty($sponsor)){
			return Redirect::to('/join');    
		}
		return View::make('pre-register.pending',compact('sponsor'));
	}

	public function verifyemail($hash){
		$keywords = preg_split("/-/", $hash);
		if(!empty($keywords) && count($keywords) == 2){
			$userid = $keywords[0];
			$shahash = $keywords[1];
			
			// Most users won't have a public ID at this point
			$user = User::where('id',$userid)->first();
			$status = '';
			

			if(!empty($user)) {
				$userid		= $user->id;
				$sponsorid	= $user->sponsor_id;
				$sponsor	= User::where('id',$user->sponsor_id)->first();
				$dob		= $user->dob;
				$email		= $user->email;

				// If they are clicking the link from the email again 
				// And have already verified and signed up
				if ($user->verified && $user->hasSignUp == 2) {
					Session::forget('pre-register');
					Session::forget('previous_page_2');
					return Redirect::to('/inventories');
				}

				if(!$user->verified || $user->hasSignUp != 2) {
					$temp = sha1(sha1($userid).sha1($dob).sha1($sponsorid));
					
					if($hash == $userid.'-'.$temp) {
						$user->verified = true;
						
						$loginuser = Auth::loginUsingId($user->id);
						
						if($user->hasSignUp == 0){
							$status = 'hasSignUp';
						}else{
							$status = 'existingRep';
						}

						$user->save();
					} else {
						return View::make('errors.missing');    
					}
				} 
				
				Session::put('pre-register.status',$status);
				
				return View::make('pre-register.main',compact('user','status','sponsor'));
			}
		}
		
		return View::make('errors.missing');
	}
	
	public function template($path='index'){
		$userid		= Auth::user()->id;
		$user		= User::where('id',$userid)->first();
		$sponsor	= User::where('id',$user->sponsor_id)->first();

		if ($user->hasSignUp == 2 && $path == 'call_in') $path = 'buystuff';

		// These come from the query string
		if (View::exists('pre-register.'.$path)) 
			return View::make('pre-register.'.$path,compact('user','sponsor'));
		else
			return View::make('pre-register.change_password',compact('user','sponsor'));    
	}
	
	public function changePassword(){
		$data = Input::all();
		$loginData = array();
		
		array_map(function($field) use(&$loginData){
			switch($field['name']){
				case 'password':
					$loginData['password'] = $field['value'];
					break;
				case 'password_confirmation':
					$loginData['password_confirmation'] = $field['value'];
					break;
			}
		},$data);
		
		$hasPass = true;
		if($loginData['password'] != $loginData['password_confirmation']){
			$hasPass = false;    
			$message = 'Password and Confirmation Password must be the same';    
		}elseif(strlen($loginData['password']) < 8 || strlen($loginData['password_confirmation']) < 8){
			$hasPass = false;    
			$message = 'Password must be at least 8 characters';  
		}
		
		if($hasPass){

			$user = User::where('id',Auth::user()->id)->first();

			// Update MWL data
			$plainpass = $loginData['password'];
			App::make('ExternalAuthController')->setmwlpassword($user->id, $plainpass);
			App::make('ExternalAuthController')->auth($user->id, $plainpass);

			$user->password = \Hash::make($loginData['password']);
			$user->save();
			$status = 'success';
			$message = 'Password successfully changed.';
		}else{
			$status = 'failed';
		}
		
		return Response::json(['status'=>$status,'message'=>$message,'next_page'=>'terms']);
	}
	
	public function addProduct(){
		$data = Input::all();
		
		$rules['name']		= 'required';
		$rules['quantity']	= 'required|numeric';
		$rules['rep_price'] = 'required|numeric';
		$rules['size']		= 'required';
		
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			$status = 'failed';
			$message = $validator->errors();
		}else{
			$data['user_id'] = Auth::user()->id;
			if(array_key_exists('id',$data)){
				$product = Product::where('id',$data['id'])->first();   
				$message = "Successfully updated product details";
			}else{
				$product = Product::create($data); 
				$message = "Successfully added product";
			}
			$product->save();
			$status = 'success';
			
			$data = $product;    
		}
		
		return Response::json(['status'=>$status,'message'=>$message,'data'=>$data]);
	}

	public function acceptTerms(){
		$rules = [
			'accept_terms'=> 'required'
		];

		$validator = Validator::make($data = Input::all(),$rules);
		//return Input::all();
		if ($validator->fails())
		{
			return Response::json(['status'=>'fail','message'=>'You must accept the terms in order to continue']);
		}

		return Response::json(['status'=>'success','message'=>'Thanks for accepting the terms','next_page'=>'bankinfo']);
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
