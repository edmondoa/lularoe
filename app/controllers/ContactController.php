<?php

class ContactController extends BaseController {

    //Server Contact view:: we will create view in next step
    public function getContact() {

        return View::make('company.contact');
    }

    //Contact Form
    public function send() {

        //Get all the data and store it inside Store Variable
        $data = Input::all();

        //Validation rules
        $rules = array('name' => 'required', 'email' => 'required|email', 'body' => 'required|min:25');

        //Validate data
        $validator = Validator::make($data, $rules);

        //If everything is correct than run passes.
        if ($validator -> passes()) {

            //Send email using Laravel send function
            $data_object = (object) $data;
            // echo"<pre>"; print_r($data_object); echo"</pre>";
            // exit;

			// LLRDEV This is where to set up contact email info
			// This should be in config somewhere?

            $message_data['data'] = Input::all();
			// get user
            Mail::send('emails.contact',$message_data, function($message) use ($data_object) {
            	// $user = User::find($data_object->user_id);
				$user = (object) array(); 
				// echo $user->email;
				// exit;
                //email 'From' field: Get users email and name
				$user->email		= Config::get('site.contact_email');
				$user->first_name	= Config::get('site.contact_first_name');
				$user->last_name	= Config::get('site.contact_last_name');
                $message->from($data_object->email, $data_object->name);
                //email 'To' field: cahnge this to emails that you want to be notified.
                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject(Config::get('site.company_name') . ' contact form: ' . $data_object->subject_line);

            });
			if(count(Mail::failures()) > 0)
			{
				//errors ocurred
				return Redirect::back()->with('message_danger','An error occurred while sending your message. Please try again later.')->withInput();
			}
			else
			{
				return Redirect::back()->with('message','Your message has been sent.');
			}
        }
        else
        {
           //return contact form with errors
           return Redirect::back()->withErrors($validator)->withInput();
        }
    }

}
