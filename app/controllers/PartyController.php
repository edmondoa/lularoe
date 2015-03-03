<?php

class partyController extends \BaseController {

	/**
	 * Display a listing of upcoming parties
	 *
	 * @return Response
	 */
	public function index()
	{
		$range = 'upcoming';
		return View::make('party.index', compact('range'));
	}

	/**
	 * Display a listing of past parties
	 *
	 * @return Response
	 */
	public function indexPast()
	{
		$range = 'past';
		$sort = 'date_end';
		return View::make('party.index', compact('range'));
	}
	
	/**
	 * Display a listing of public parties
	 *
	 * @return Response
	 */
	public function publicIndex()
	{
		$title = 'Company Parties';
		return View::make('party.public_index', compact('title'));
	}

	/**
	 * Show the form for creating a new party
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			$party = new Party;
			$party->timezone = Session::get('timezone');
			return View::make('party.create', compact('party'));
			Timezone::convertFromUTC($session->created_at);
		}
	}

	/**
	 * Store a newly created party in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			$validator = Validator::make($data = Input::all(), Party::$rules);
			
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
			// format dates and times for database
			$data['date_start'] = strtotime($data['date_start']);
			$data['date_end'] = strtotime($data['date_end']);
			
			// add organizer_id
			$data['organizer_id'] = Auth::user()->id;
			
			// store address
		    $address = Address::create([
		    	'addressable_type' => 'Party',
		    	'label' => $data['label'],
		    	'address_1' => $data['address_1'],
		    	'address_2' => $data['address_2'],
		    	'city' => $data['city'],
		    	'state' => $data['state'],
		    	'zip' => $data['zip'],
		    ]);
			
			// store party
			$party = Party::create($data);
			
			// store address
			$party->address()->save($address);
			
			// attach images
			if (isset($data['images'])) {
				foreach($data['images'] as $key => $image) {
					$image['featured'] = isset($image['featured']) ? 1 : 0;
					$image['path'] = explode('/uploads/', $image['path']);
					$image['path'] = $image['path'][1];
					$media = Media::where('url', $image['path'])->get()->first();
					$attachment = Attachment::create([
						'attachable_type' => 'Party',
						'attachable_id' => $party->id,
						'media_id' => $media->id,
						'featured' => $image['featured'],
					]);
				}
			}
			
			return Redirect::route('parties.index')->with('message', 'Popup-Boutique created.');
		}
	}

	/**
	 * Display the specified party.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$party = Party::findOrFail($id);
		$address = Party::find($id)->address;

		// leads attending
		$lead_registrations = Registration::where('registerable_type', 'Party')->where('registerable_id', $id)->where('person_type', 'Lead')->where('status', 'attend')->get();
		$leads_attending = [];
		foreach($lead_registrations as $lead_registration) :
			$leads_attending[] = Lead::find($lead_registration->person_id);
		endforeach;
		
		// users attending
		$user_registrations = Registration::where('registerable_type', 'Party')->where('registerable_id', $id)->where('person_type', 'User')->where('status', 'attend')->get();
		$users_attending = [];
		foreach($user_registrations as $user_registration) :
			$users_attending[] = user::find($user_registration->person_id);
		endforeach;
		
		// leads declined
		$lead_declines = Registration::where('registerable_type', 'Party')->where('registerable_id', $id)->where('person_type', 'Lead')->where('status', 'decline')->get();
		$leads_declined = [];
		foreach($lead_declines as $lead_decline) :
			$leads_declined[] = Lead::find($lead_decline->person_id);
		endforeach;
		
		// users declined
		$user_declines = Registration::where('registerable_type', 'Party')->where('registerable_id', $id)->where('person_type', 'User')->where('status', 'decline')->get();
		$users_declined = [];
		foreach($user_declines as $user_decline) :
			$users_declined[] = user::find($user_decline->person_id);
		endforeach;

		// get party images
		$attachment_images = [];
		$attachments = Attachment::where('attachable_type', 'Party')->where('attachable_id', $party->id)->get();
		foreach ($attachments as $attachment) {
			$image = Media::find($attachment->media_id);
			// die($attachment->media_id);
			if ($attachment->featured == 1) $party->featured_image = $image;
			$image_sm = explode('.', $image->url);
			if (isset($image_sm[1])) $image_sm = $image_sm[0] . '-sm.' . $image_sm[1];
			else $image_sm = '';
			$attachment_images[] = $image_sm;
		}

		return View::make('party.show', compact('party', 'address', 'leads_attending', 'leads_declined', 'users_attending', 'users_declined', 'attachment_images'));
	}

	/**
	 * Display the specified party.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function publicShow($id)
	{
		$party = Party::findOrFail($id);
		$address = Party::find($id)->address;
		$organizer = User::find($party->organizer_id);
		
		// create party session
		Session::put('party_id', $party->id);
		Session::put('organizer_id', $organizer->id);
		
		// leads attending
		$lead_registrations = Registration::where('registerable_type', 'Party')->where('registerable_id', $id)->where('person_type', 'Lead')->where('status', 'attend')->get();
		$leads_attending = [];
		foreach($lead_registrations as $lead_registration) :
			$leads_attending[] = Lead::find($lead_registration->person_id);
		endforeach;
		
		// users attending
		$user_registrations = Registration::where('registerable_type', 'Party')->where('registerable_id', $id)->where('person_type', 'User')->where('status', 'attend')->get();
		$users_attending = [];
		foreach($user_registrations as $user_registration) :
			$users_attending[] = user::find($user_registration->person_id);
		endforeach;
		
		// get party images
		$attachment_images = [];
		$attachments = Attachment::where('attachable_type', 'Party')->where('attachable_id', $party->id)->get();
		foreach ($attachments as $attachment) {
			$image = Media::find($attachment->media_id);
			// die($attachment->media_id);
			if ($attachment->featured == 1) $party->featured_image = $image;
			$image_sm = explode('.', $image->url);
			if (isset($image_sm[1])) $image_sm = $image_sm[0] . '-sm.' . $image_sm[1];
			else $image_sm = '';
			$attachment_images[] = $image_sm;
		}
		
		return View::make('party.public_show', compact('party', 'address', 'leads_attending', 'users_attending', 'organizer', 'attachment_images'));
	}

	/**
	 * Show the form for editing the specified party.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			$party = Party::find($id);
			$start_date_stamp = date('Y-m-d G:i:s', $party->date_start);
			$end_date_stamp = date('Y-m-d G:i:s', $party->date_end);
			$party->date_start = Timezone::convertFromUTC($start_date_stamp, $party->timezone, 'm/d/Y g:i a');
			$party->date_end = Timezone::convertFromUTC($end_date_stamp, $party->timezone, 'm/d/Y g:i a');
			if (!isset($party->timezone)) $party->timezone = Session::get('timezone');
			
			// get party images
			$attachment_images = [];
			$image_attachments = Attachment::where('attachable_type', 'Party')->where('attachable_id', $party->id)->orderBy('id', 'desc')->get();
			foreach ($image_attachments as $image_attachment) {
				$media = Media::find($image_attachment->media_id);
				$media->featured = $image_attachment->featured;
				$media->attachment_id = $image_attachment->id;
				$attachment_images[] = $media;
			}
			if (count($attachment_images) > 0) {
				$attachment_images_count = end($attachment_images);
				$attachment_images_count = $attachment_images_count->id;
			}
			else $attachment_images_count = 0;
			
			return View::make('party.edit', compact('party', 'attachment_images', 'attachment_images_count'));
		}
	}

	/**
	 * Update the specified party in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			$party = Party::findOrFail($id);
	
			$validator = Validator::make($data = Input::all(), Party::$rules);
	
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
			// format dates and times for database
			$data['date_start'] = Timezone::convertToUTC($data['date_start'], $data['timezone']);
			$data['date_start'] = strtotime($data['date_start']);
			$data['date_end'] = Timezone::convertToUTC($data['date_end'], $data['timezone']);
			$data['date_end'] = strtotime($data['date_end']);
			
			// store/update party images
			if (isset($data['images'])) {
				foreach($data['images'] as $key => $image) {
					
					// new images
					if (isset($image['new_attachment_image'])) {
						$image['featured'] = isset($image['featured']) ? 1 : 0;
						$image['path'] = explode('/uploads/', $image['path']);
						$image['path'] = $image['path'][1];
						$media = Media::where('url', $image['path'])->get()->first();
						$attachment = Attachment::create([
							'attachable_type' => 'Party',
							'attachable_id' => $party->id,
							'media_id' => $media->id,
							'featured' => $image['featured'],
						]);
					}
					
					// update existing images
					else {
						$image['featured'] = isset($image['featured']) ? 1 : 0;
						$attachment = Attachment::find($image['attachment_id']);
						$attachment->update([
							'featured' => $image['featured'],
						]);
					}
					
				}
			}
			
			$party->update($data);
			
			return Redirect::route('parties.show', $id)->with('message', 'Popup-Boutique updated.');
		}
	}

	/**
	 * RSVP for the specified party.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function RSVP($party_id, $person_id, $person_type, $status)
	{
		$party = Party::findOrFail($party_id);
		$address = Party::find($party_id)->address;
		// if ($person_type == 'Lead') $person = Lead::find($person_id);
		// else $person = User::find($person_id);
		$title = $party->name;
		if (Registration::where('registerable_id', $party->id)->where('registerable_type', 'Party')->where('person_id', $person_id)->where('person_type', $person_type)->count() == 0) {
			Registration::create([
				'registerable_id' => $party->id,
				'registerable_type' => 'Party',
				'person_id' => $person_id,
				'person_type' => $person_type,
				'status' => $status
			]);
		}
		$organizer = User::find($party->organizer_id);
		$host = Lead::find($party->host_id);
		
		if ($status == 'attend') {
			// Notify Organizer
			$user = User::find($party->organizer_id);
			$data['user'] = $user;
			$data['lead'] = Lead::find($person_id);
			$data['body'] = 'Good news: ' . $data['lead']->first_name . ' ' . $data['lead']->last_name . ' will be attending your party. You can communicate with ' . $data['lead']->first_name . ' and manage your party at ' . url() . '/parties/' . $party->id;
			Mail::send('emails.standard', $data, function($body) use($user,$data)
			{
				$body
				->to($user->email, $data['user']->first_name . ' ' . $data['user']->last_name)
				->subject($data['lead']->first_name . ' ' . $data['lead']->last_name . ' will be attending your party.')
				->from(Config::get('site.default_from_email'), Config::get('site.company_name'));
			});
		}
		
		return View::make('party.rsvp', compact('party', 'address', 'title', 'status', 'organizer', 'host'));
	}

	/**
	 * RSVP as a host the specified party.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function hostRSVP($party_id, $person_id, $person_type, $status)
	{
		$party = Party::findOrFail($party_id);
		$address = Party::find($party_id)->address;
		// if ($person_type == 'Lead') $person = Lead::find($person_id);
		// else $person = User::find($person_id);
		$title = $party->name;
		if (Registration::where('registerable_id', $party->id)->where('registerable_type', 'Party')->where('person_id', $person_id)->where('person_type', $person_type)->count() == 0) {
			Registration::create([
				'registerable_id' => $party->id,
				'registerable_type' => 'Party',
				'person_id' => $person_id,
				'person_type' => $person_type,
				'status' => $status
			]);
		}
		$organizer = User::find($party->organizer_id);
		$data['host'] = Lead::find($person_id);
		$party->update([
			'host_id' => $data['host']->id
		]);
				
		// Notify Organizer
		$user = User::find($party->organizer_id);
		$data['user'] = $user;
		$data['body'] = 'Good news: ' . $data['host']->first_name . ' ' . $data['host']->last_name . ' has agreed to host your party. You can communicate with ' . $data['host']->first_name . ' and manage your party at ' . url() . '/parties/' . $party->id;
		Mail::send('emails.standard', $data, function($body) use($user,$data)
		{
			$body
			->to($user->email, $data['user']->first_name . ' ' . $data['user']->last_name)
			->subject($data['host']->first_name . ' ' . $data['host']->last_name . ' has agreed to host your party.')
			->from(Config::get('site.default_from_email'), Config::get('site.company_name'));
		});
		
		return View::make('party.rsvp-host', compact('party', 'address', 'title', 'status', 'organizer', 'lead'));
	}

	/**
	 * Remove the specified party from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			Party::destroy($id);
	
			return Redirect::route('parties.index')->with('message', 'Popup-Boutique deleted.');
		}
	}
	
	/**
	 * Remove parties.
	 */
	public function delete()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			foreach (Input::get('ids') as $id) {
				Party::destroy($id);
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('parties.index')->with('message', 'Popup-Boutiques deleted.');
			}
			else {
				return Redirect::back()->with('message', 'Popup-Boutique deleted.');
			}
		}
	}
	
	/**
	 * Diable parties.
	 */
	public function disable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			foreach (Input::get('ids') as $id) {
				Party::find($id)->update(['disabled' => 1]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('parties.index')->with('message', 'Popup-Boutiques disabled.');
			}
			else {
				return Redirect::back()->with('message', 'Popup-Boutique disabled.');
			}
		}
	}
	
	/**
	 * Enable parties.
	 */
	public function enable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep'])) {
			foreach (Input::get('ids') as $id) {
				Party::find($id)->update(['disabled' => 0]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('parties.index')->with('message', 'Popup-Boutiques enabled.');
			}
			else {
				return Redirect::back()->with('message', 'Popup-Boutique enabled.');
			}
		}
	}

}