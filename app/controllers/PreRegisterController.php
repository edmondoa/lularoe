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
		$rules = User::$rules;
		//create som new ones for this form

		$rules['address_1'] = 'required|between:2,28';
		$rules['city'] = 'required';
		$rules['state'] = 'required|size:2';
		$rules['zip'] = ['required','numeric','regex:/(^\d{5}$)|(^\d{5}-\d{4}$)/'];
		$rules['dob'] = 'required|before:'.date('Y-m-d',strtotime('18 years ago'));
		$rules['agree'] = 'required|accepted';
		$rules['password'] = 'required|confirmed|between:8,32';
		$rules['public_id'] = 'required|unique:users,public_id';
		$rules['email'] = 'required|unique:users,email';
		$rules['sponsor_id'] = 'required';
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
        
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
            'label'=>'Billing',
        ];
        $address = Address::create($address);
        $user->addresses()->save($address);
        
        $role = Role::where('name','Rep')->first();
        //echo"<pre>"; print_r($role); echo"</pre>";
        $user->role()->associate($role);
        $user->hasSignUp = true;
        $user->save();
		
		//User::create($data);
		//exit;
		$userSite = UserSite::firstOrNew(['user_id'=> $user->id]);
		$user->userSite()->associate($userSite);
		Event::fire('rep.create', array('rep_id' => $user->id));
		#$loginuser = Auth::loginUsingId($user->id);
        
        
        $userid = $user->id;
        $sponsorid = $user->sponsor_id;
        $dob = $user->dob;
        $public_id = $user->public_id;
        $email =  $user->email;
        
        $sponsor = User::where('id',$sponsorid)->first();
        Session::put('sponsor',$sponsor);
        
        $hash = sha1(sha1($userid).sha1($dob).sha1($sponsorid));
        $verification_link = 'http://'.Config::get('site.domain').'/u/'.$public_id.'-'.$hash; 
        
        Mail::send('emails.verification', compact('verification_link'), function($message) use(&$user)
        {
            $message->to($user->email, $user->first_name.' '.$user->last_name)->subject('Verify Your Email Address');
        });
        
		return Redirect::to('/pending-registration');
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
            $public_id = $keywords[0];
            $shahash = $keywords[1];
            
            $user = User::where('public_id',$public_id)->first();
            $status = '';
            
            if(!empty($user)){
                $userid = $user->id;
                $sponsorid = $user->sponsor_id;
                $dob = $user->dob;
                $email = $user->email;
                if(!$user->verified){
                    $temp = sha1(sha1($userid).sha1($dob).sha1($sponsorid));
                    
                    if($hash == $public_id.'-'.$temp){
                        $user->verified = true;
                        $user->save();
                        
                        $loginuser = Auth::loginUsingId($user->id);
                        
                        if($user->hasSignUp){
                            $status = 'hasSignUp';
                        }else{
                            $status = 'existingRep';
                        }
                    }else{
                        return View::make('errors.missing');    
                    }
                }else{
                    $status = 'done';
                }
                
                
                return View::make('pre-register.main',compact('status'));
            }
        }
        
        return View::make('errors.missing');
    }
    
    public function template($path='index'){
        switch($path){
            case 'other':
                return;
                break;
            default:
                return View::make('pre-register.changepassword');
                break;
        }
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
