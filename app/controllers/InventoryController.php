<?php

class InventoryController extends \BaseController {

	// HARDCODED for now, definitely pullable from a DB though
	// Discounts are SUBTRACTIVE, meaning the total is combined together
	// then SUBTRACTED from the total
    public $discounts = array(
			[		'title'		=>'Incentive Discount',
					'repsale'	=>false,
					'math'		=>array('op'=>'*','n'=>.05)],
/*
			[		'title'		=>'Super 15% Discount',
					'repsale'	=>true,
					'math'		=>array('op'=>'*','n'=>.15)],
*/
			//* Just as an example	
			//['title'=>'$5 Bump','math'=>array('op'=>'=','n'=>5.00)]
		);

    /**
     * Data only
     */
    public function matrix() {
		return View::make('inventory.matrix');
    }

	public function viewInvoice($id) {
		$invoice	= Receipt::find($id);

		$invoice->data = json_encode($this->fixOrderData(json_decode($invoice->data,true), true));
		//return Response::json($invoice->data,200,array(),JSON_PRETTY_PRINT);
		Session::flash('orderdata', $invoice);
		// Probably make this un-editable
        return View::make('inventory.invoiceCheckout',compact('invoice','orderdata'));
	}

	
	public function showInvoice($public_id, $id) {
		$invoice	= Receipt::find($id);
		Session::flash('orderdata', $invoice);
        return View::make('inventory.invoiceCheckout',compact('invoice','orderdata'));
	}

    /**
     * Data only
     */
    public function getAllInventories(){
        
        return [
            'count' => Inventory::count(),
            'data' => Inventory::all()
        ];
    }


	public function getDiscounts($subt, $viaRequest=true,$doTemplate=false){
		// Init my vars
		$discounted	= array();
		$dctotal	= 0;

		if (Input::has('discount')) {
			if (Input::get('discount') == 0) Session::forget('customdiscount');
			else Session::put('customdiscount', Input::get('discount'));
		}

		if (Session::get('customdiscount')) {
			$this->discounts[] = array('title'	=> 'Special Discount',
								  'math'=>array('op'=>'=','n'=>floatVal(Session::get('customdiscount'))),
								  'repsale'=>true);
		}

		// Do the MATHS
		foreach ($this->discounts as $discount) {
			// I <3 Eval .. NOT!
			if (Session::has('repsale') && ($discount['repsale'] == Session::get('repsale'))) {
				if ($discount['math']['op'] == '=') 
					$dcamt = $discount['math']['n'];
				else
					$dcamt = eval('return (floatVal($subt)'.$discount['math']['op'].$discount['math']['n'].');');

				if ($dcamt){
					$discounted[] = array(	'title'		=> $discount['title'],
											'amount'	=> $dcamt);
					$dctotal += $dcamt;
				}
			}
		}

		$discounted['total'] = $dctotal;
		$discounted['repsale'] = Session::get('repsale');


		// Return my requestors appropriately
        if(Request::wantsJson()){
            return Response::json($discounted);
        }else{
            if($viaRequest){
                return $dctotal;
            }else{
                return $discounted;
            }
        }
	}

    public function getTax($value,$viaRequest=true,$doTemplate=false){

		if (!Session::get('repsale'))  { 
			// TURN OFF TAX ON NON-REP SALE FOR NOW
			$value = 0;
			$data = file_get_contents('https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/33.8667,-117.5667/get?saleamount='.$value);
			$tax = json_decode($data);
		}
		else { 
			// <sarc>Thanks Avalara for not having an API based on address.</sarc>
			$a = Auth::user()->addresses;
			$zipcode = $a[0]->zip;
			if (Cache::has('tax-'.$zipcode)) {
				$googhelp = Cache::get('tax-'.$zipcode);
			}
			else {
				$googhelp = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=84047');
				Cache::put('tax-'.$zipcode, $googhelp, 86400);
			}

			$googdata = json_decode($googhelp);
			$latlon = $googdata->results[0]->geometry->location;

            $data = file_get_contents("https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/{$latlon->lat},{$latlon->lng}/get?saleamount=".$value);

			$tax = json_decode($data);
		}

        if($doTemplate) return $tax;
        if(Request::wantsJson()){
            return Response::json($tax);
        }else{
            if($viaRequest){
                return $tax->Tax;
            }else{
                return $tax;
            }
        }
    }


    /**
     * Process order checkout
     * 
     */
    public function checkout()
    {
        $orders = Session::get('orderdata');
        if(empty($orders)) $orders = array();
        $subtotal   = 0;
        $inittotal  = 0;
        array_map(function($order) use (&$inittotal){
            $inittotal += floatval($order['price']) * intval($order['numOrder']);    
        },$orders);

		$discounts	= $this->getDiscounts($inittotal,false,true);
		if ($discounts['total'] > 0) $inittotal = $inittotal - $discounts['total'];

		$tax = $this->getTax($inittotal);

        Session::put('emailto',Input::get('emailto'));
        Session::put('discounts',$discounts);
        Session::put('subtotal',$inittotal);
        Session::put('tax',$tax);

        return View::make('inventory.checkout',compact('discounts', 'orders','inittotal','tax','subtotal'));    
    }

    
	/**
	 * Display a listing of inventories
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::put('repsale', false);
		$inventories = Inventory::all();

		return View::make('inventory.index', compact('inventories'));
	}
	
	/**
	 * Display a listing of inventories (after initial onboarding)
	 *
	 * @return Response
	 */
    public function matrixFull($by_group = false) {
		Session::put('repsale', false);
		$inventories = Inventory::all();

		// Hackery - get this users bank info if ordering from onboarding
		if (Auth::user()->hasRole(array('Superadmin','Admin')) && $by_group) {
			session::put('userbypass',$by_group);
		}

		return View::make('inventory.index', compact('inventories', 'by_group'));
    }

	/**
	 * Show the form for creating a new inventory
	 *
	 * @return Response
	 */
	public function create()
	{
		$inventory = Inventory::all();

		return View::make('inventory.create', compact('inventory'));
	}

	/**
	 * Store a newly created inventory in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Inventory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Inventory::create($data);

		return Redirect::route('inventory.index');
	}

	/**
	 * Display the specified inventory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$inventory = Inventory::findOrFail($id);

		return View::make('inventory.show', compact('inventory'));
	}

	/**
	 * Show the form for editing the specified inventory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        
		$inventory = Inventory::find($id);
        if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
		    return View::make('inventory.edit', compact('inventory'));
        }
	}

	/**
	 * Update the specified inventory in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$inventory = Inventory::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Inventory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$inventory->update($data);

		return Redirect::route('inventories.index');
	}

	/**
	 * Remove the specified inventory from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Inventory::destroy($id);

		return Redirect::route('inventories.index');
	}
    
    /**
     * Remove inventories.
     */
    public function delete()
    {
        foreach (Input::get('ids') as $id) {
            Inventory::destroy($id);
        }
        if (count(Input::get('ids')) > 1) {
            return Redirect::route('inventories.index')->with('message', 'Inventories deleted.');
        }
        else {
            return Redirect::back()->with('message', 'Inventory deleted.');
        }
    }
    
    /**
     * Diable inventories.
     */
    public function disable()
    {
        foreach (Input::get('ids') as $id) {
            Inventory::find($id)->update(['disabled' => 1]);    
        }
        if (count(Input::get('ids')) > 1) {
            return Redirect::route('inventories.index')->with('message', 'Inventory disabled.');
        }
        else {
            return Redirect::back()->with('message', 'Inventory disabled.');
        }
    }
    
    /**
     * Enable inventories.
     */
    public function enable()
    {
        foreach (Input::get('ids') as $id) {
            Inventory::find($id)->update(['disabled' => 0]);    
        }
        if (count(Input::get('ids')) > 1) {
            return Redirect::route('inventories.index')->with('message', 'Inventories enabled.');
        }
        else {
            return Redirect::back()->with('message', 'Inventory enabled.');
        }
    }

    /**
     * Process order checkout
     * 
     */
    public function sales()
    {
			Session::put('repsale',true);
            return View::make('inventory.repsales');
    }
	
	public function totalCheck($absamount) {
		// Get the full order amount currently pending purchase
		$tax = Session::get('tax');
		$sub = Session::get('subtotal');

		// Discounts are previously calculated and store in subtotal
		$grandTotal = floatVal($tax) + floatVal($sub);

		if ($absamount > ($grandTotal - Session::get('paidout'))) 
			$absamount = $grandTotal - Session::get('paidout');

		return($absamount);
	}

	public function checkFinalSaleAmount($saleAmount) {

		// Get the full order amount currently pending purchase
		$tax = Session::get('tax');
		$sub = Session::get('subtotal');

		$grandTotal = floatVal($tax) + floatVal($sub);

		$po = Session::get('paidout', 0);
		Session::put('paidout',floatval($po) + floatval($saleAmount));

		// If the sale amount is still less than the grand total
		if (Session::get('paidout') < $grandTotal) {
			$diffAmount = floatVal($grandTotal) - floatVal($saleAmount);

			return false; // Not done paying YET!
		}
		// else we are done paying
		else  {
			return true; 
		}
	}


	// Consignment purchase
	public function conspurchase() {

		// This means the superadmin can set a user to "order for someone" 
		// more on this functionality later
		if (Auth::user()->hasRole(array('Superadmin','Admin')) && Session::has('userbypass')) {
			$currentuser = User::find(Session::get('userbypass'));
		}
		else {
			$currentuser = Auth::user();
		}
		
		Session::put('notes',Input::get('notes'));
		Session::put('to_email',Input::get('to_email'));
		Session::put('to_firstname',Input::get('to_firstname'));
		Session::put('to_lastname',Input::get('to_lastname'));


		// Make sure we have enough consignment to pull this off
		$cons 		= $currentuser->consignment;
		$absamount	= abs(Input::get('amount'));
		$absamount = $this->totalCheck($absamount);


		if ($cons <= 0) {
			$cardauth = new stdClass();
			$cardauth->status = 'No consignment is currently available to you.';
			return View::make('inventory.invalidpurchase',compact('cardauth'));
		}
		
		// If we try to pay with more cons than we have
		if ($cons < $absamount) { 
			// Set it to maximum $cons
			Input::replace(array('amount'=>$cons));
		}

		if (!Session::has('orderdata')) {
			return Redirect::route('dashboard');
		}

		// Tax only on repsales not on inventory purchases
		$tax		= $this->getTax($absamount);

		// If consignment not funds available set to max amount
		$invitems	= Session::get('orderdata');

		$authinfo = new stdClass();
		$oldInput = Input::all();

		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!Session::get('repsale')) {
			// For MWL user loginstuff
			$user = Config::get('site.mwl_username');
			$pass = Config::get('site.mwl_password');

			$authinfo = json_decode(App::make('ExternalAuthController')->midauth($user, $pass, true));
		}
		// This is the individual REP TID
		else {
			$authkey = $currentuser->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->key = $key;
		}

		$purchaseInfo = array(
					'subtotal'		=>$absamount,
					'tax'			=>$tax,
					'cash'			=>2,
					'cart'			=>json_encode($invitems)
				);

		
		//$ia = Input::all();
		//Input::replace($purchaseInfo);
		//$request	= Request::create('llrapi/v1/purchase/'.$authinfo->key,'GET', array());
		//$cardauth	= json_decode(Route::dispatch($request)->getContent());
		//Input::replace($ia);

		// Always no error on consignment with positive balance
		$cardauth	= json_decode('{ "error":false }');

		if (!$cardauth->error) {
			$user = $currentuser;
			$user->consignment = $user->consignment - floatval($absamount);
			$user->save();

			$cardauth	= array('error'=>false,
								'result'=>'Approved',
								'status'=>'Consignment',
								'balance'=>$user->consignment,
								'amount'=>$absamount);

			$this->addPayment($cardauth);

			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			return $this->finalizePurchase($cardauth, $invitems);
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth'));
	}

	public function addPayment($order, $key = 'paymentdata') {
		$c = Session::get($key);
		$c[] = $order;
		Session::put($key, $c);
		// return Session::save();
	}

	private function mergeOrderData($orderdata = array(), $removeunusedsizes = false) {
		// List of sizes in order
        $sizelist	= array('XXS'=>0,'XS'=>0,'S'=>0,'M'=>0,'L'=>0,'XL'=>0,'2XL'=>0,'3XL'=>0,'S/M'=>0,'S/M & L/XL'=>0,'L/XL'=>0,'2'=>0,'4'=>0,'6'=>0,'8'=>0,'10'=>0,'12'=>0,'14'=>0,'3/4'=>0,'5/6'=>0,'8/10'=>0,'One Size'=>0,'Tall & Curvy'=>0);
        $m			= array();
		$hassizes	= array();


		// Creates the entire order manifest
        foreach($orderdata as $o) {
            $om = $o['model'];

            if (!is_array(@$m[$om]['quantities'])) {
                $m[$om]['quantities'] = $sizelist;
            }

            foreach($o['quantities'] as $size=>$num) {
				if (intval($num) > 0) @$hassizes[$size] += intval($num);

				if (!isset($m[$om]['quantities'][$size])) $m[$om]['quantities'][$size] = 0;
				$m[$om]['quantities'][$size] += intval($num);
            }

        }

		// This reduces the size of the order grid to only contain the sizes that are used on the manifest
		if ($removeunusedsizes) {
			foreach($m as $om=>$o) {
				foreach($o['quantities'] as $size=>$num) {
					if (!isset($hassizes[$size])) unset($m[$om]['quantities'][$size]);
				}
			}
		}

        return($m);
    }

	// Better name create invoice
	public function sendInvoice($key = '') {

		// If we're passing a key, coming from api / json
		if (!empty($key)) {
			$user = App::make('ExternalAuthController')->getUserByKey($key);

			// First we fetch the Request instance
			$request = Request::instance();

			// Now we can get the content from it
			$content = $request->getContent();
			$vals = json_decode($content,true);

			$orderdata	= $vals['orderdata'];
		}
		else {
			// Get the order data from the session
			$orderdata  = $this->mergeOrderData($this->fixOrderData(Session::get('orderdata')), true);
			$user		= Auth::user();
			$vals 		= Input::all();
		}

		$sessiondata = Session::all();

		// This means we are getting the javascript style order data
		if (isset($sessiondata['orderdata'][0]['numOrder'])) {
			$data['total_items_ordered'] = 0;
			// Count the number of items ordered
			foreach($sessiondata['orderdata'] as $items) {
				$data['total_items_ordered'] += intval($items['numOrder']);
			}			
			$sessiondata['orderdata'] = $this->fixOrderData($sessiondata['orderdata']);
		}

		$inv = new Receipt();
		$inv->user_id	= $user->id;
		$inv->subtotal	= floatval($vals['amount']) + floatval($sessiondata['paidout']);
		$inv->note		= $vals['note'];
		$inv->to_email	= $vals['emailto'];
		$inv->tax		= !empty($vals['tax']) 		? floatval($vals['tax']) : 0;
		$inv->balance	= $vals['amount'];

		// Make nice with the explode
		if (strpos($vals['customername'], ' ')  === false) {
			$inv->to_firstname = $vals['customername'];
			$inv->to_lastname  = 'N/A';
		}
		else {
			list($inv->to_firstname,$inv->to_lastname)	= explode(' ',$vals['customername']);
		}

		$inv->data		= json_encode($sessiondata['orderdata']);
		$inv->save();

		$data['payment_url'] = '';
		// Invoice Payment Url
		if ($inv->balance > 0) $data['payment_url'] = 'https://'.$user->public_id.'.'.Config::get('site.domain')."/invoice/pay/{$inv->id}";

		// Build the content of the email message
		$data['body'] = $this->buildOrderTable($orderdata);
		$data['user'] = $user;
		$data['inv']  = $inv;
		$data['date'] = date('Y-m-d H:i:s');

		\Log::info("Dispatching invoice to {$inv->to_email}");
		try { 
			Mail::send('emails.invoice', $data, function($message) use($user, $data, $inv) {
				$message->to($inv->to_email, "{$inv->to_firstname} {$inv->to_lastname}");
				$message->subject('Invoice From: '."{$user->first_name} {$user->last_name}");
				$message->from($user->email, $user->first_name.' '.$user->last_name);
			});
		} catch (Exception $e) {
			die('Check your email address you are sending to: '.$e->getMessage());
		}
		

		return View::make('inventory.invoicesent', compact('sessiondata','user','data','inv'));
	}

	private function buildOrderTable($od) {
		$bgdark = '#EFEFEF';
		$bglight = '#FFFFFF';
		$bgc = 0;
		
		$databody = "<table width='100%' cellpadding=\"0\" cellspacing=\"0\"><tr><th>Model</th>";
		$heading = reset($od);
			foreach($heading['quantities'] as $size=>$quan) {
				$bg = ($bgc++ %2  ==0) ? $bgdark : $bglight;
				$databody .= "<th style=\"border:1px dotted #CDCDCD;background:{$bg}\">{$size}</th>";
			}
		$databody .= "</tr>";
		foreach($od as $model=>$item) {
			$databody .= "<tr><td>{$model}</td>";
			foreach($item['quantities'] as $size=>$quan) {
				$bg = ($bgc++ %2  ==0) ? $bgdark : $bglight;
				$hilight = "padding:5px;border:1px dotted #CDCDCD;background:{$bg}";
				if ($quan < 1) {
					$hilight = "padding:5px;border:1px dotted #CDCDCD;background:{$bg}";
					$quan = '';
				}
				$databody .= "<td align=\"center\" style=\"{$hilight}\">{$quan}</td>";
			}
		}
		$databody .= "</tr></table>";
		return $databody;
	}


	// Until we get this fixed from the javascript submittal
	public function fixOrderData($od) {
		// This creates the correct array out of the order data 
		foreach($od as $items) {
			$sod[] = array(
				'id'		=> isset($items['id']) ? $items['id'] : '',
				'model'		=> $items['model'],
				'price'		=> $items['price'],
				'quantities'=> array($items['size'] => $items['numOrder'])
			);
		}
		return $sod;
		//----------- FIX THIS IN THE ORDER JSON GENERATION
	}

	public function putOrderInMyInventory($user, $od) {
		foreach($od as $item) {
			$model = $item['model'];
			$price	 = $item['price'];
			foreach($item['quantities'] as $size=>$numOrdered) {

				\Log::info("Adding inventory to User: {$user->id} Model: {$model} Size: {$size} Quantity: {$numOrdered} Price: {$price}");
				$prod = Product::where('user_id',$user->id)->where('name',$model)->where('size',$size)->first();

				if (isset($prod->quantity)) { 
					$prod->quantity += intval($numOrdered); 
				}
				else {
					$prod			= new Product();
					$prod->user_id 	= $user->id;
					$prod->name 	= $model;
					$prod->rep_price= floatval($item['price']) + (floatval($item['price']) * .3);
					$prod->size		= $size;
					$prod->quantity = intval($numOrdered);
					$prod->price	= floatval($item['price']);
				}
				$prod->save();

			}

		}
	}

	public function finalizePurchase($auth, $invitems, $currentuser = '') {
		\Log::info('FINALIZING PURCHASE '.json_encode($currentuser));

		if (empty($currentuser)) { 
			// This means the superadmin can set a user to "order for someone" 
			// more on this functionality later
			if (Auth::user()->hasRole(array('Superadmin','Admin')) && Session::has('userbypass')) {
				$currentuser = User::find(Session::get('userbypass'));
			}
			else {
				$currentuser = Auth::user();
			}
		}

		$user = $currentuser;

		$sessiondata = Session::all();
		$csuser 	 = '';

		// This is for consignment purchase only
		if (!empty($sessiondata['consignment_purchase'])) {
			$consuid 				= $sessiondata['consignment_purchase'];
			$csuser					= User::find($consuid);
			$csuser->consignment 	+= 	$sessiondata['subtotal'];
			$sessiondata['emailto'] = 	$csuser->email;
			$csuser->save();
		}

		$data		= [];

		// This means we are getting the javascript style order data
		if (isset($sessiondata['orderdata'][0]['numOrder'])) {

			$data['total_items_ordered'] = 0;
			// Count the number of items ordered
			foreach($sessiondata['orderdata'] as $items) {
				$data['total_items_ordered'] += intval($items['numOrder']);
			}			
			$sessiondata['orderdata'] = $this->fixOrderData($sessiondata['orderdata']);
		}

		$view  = View::make('inventory.validpurchase',compact('auth','invitems','sessiondata'));

		$data['body'] = $view->renderSections()['manifest'];


		// If the session has an emailto person
		$data['email'] = isset($sessiondata['email_to']) ? $sessiondata['email_to'] : $user->email;

		$data['user']	= $user;
		$data['email']	= $user->email;

		// If ordering NEW inventory
		if (!Session::get('repsale'))
		{
			$user = (!empty($csuser->sponsor_id)) ?  $csuser : $user;

			$emailto = Config::get('site.warehouse_email');
			// $emailto = 'mfrederico@gmail.com';
			$data['email']	= $emailto;

			$inv = new Receipt();
			$inv->date_paid		= date('Y-m-d H:i:s');
			$inv->user_id		= Config::get('site.mwl_username');
			$inv->subtotal		= $sessiondata['subtotal'];
			$inv->note			= isset($sessiondata['notes']) ? $sessiondata['notes'] : '';
			$inv->to_email		= $user->email;
			$inv->tax			= $sessiondata['tax'];
			$inv->balance		= $sessiondata['subtotal'] - $sessiondata['paidout'];
			$inv->to_firstname  = $user->first_name;
			$inv->to_lastname	= $user->last_name;
			$inv->data			= json_encode($sessiondata['orderdata']);
			$data['receipt_id'] = $inv->save();

			// This should eventually be scanned in, but whatevs 
			$this->putOrderInMyInventory($user, $sessiondata['orderdata']); // Previsouly Fixed see above

			// Fix the weird shit that the JS gives me from orderdata
			$od = $this->mergeOrderData($sessiondata['orderdata'], true);
			
			// Build the order table based on what we're ordering
			$data['body'] = $this->buildOrderTable($od);
			$data['user'] = $user;
			$data['inv']  = $inv;
			$data['date'] = date('Y-m-d H:i:s');
			$data['note'] = $sessiondata['notes'];

			// This one goes to the main warehouse
			try { 

				\Log::info("Dispatching order invoice off to {$data['email']}");
				Mail::send('emails.invoice', $data, function($message) use($user, $data, $inv) {
					$message->to($data['email'], "Order Warehousing");
					$message->subject('Invoice From: '."{$user->first_name} {$user->last_name}");
					$message->from($user->email, $user->first_name.' '.$user->last_name);
				});
			} catch (Exception $e) {
				\Log::error('Invoice did not get sent to order warehouseing.');	
			}

			try { 
				\Log::info("Dispatching receipt email to {$user->email}");
				Mail::send('emails.invoice', $data, function($message) use($user,$data, $inv) {
					$message->to($user->email, "{$user->first_name} {$user->last_name}");
					$message->subject("Order Receipt for {$data['total_items_ordered']} items");
					$message->replyTo($data['email']);
					$message->from(Config::get('site.default_from_email'), Config::get('site.company_name'));
				});
			} catch (Exception $e) {
				\Log:: error("Receipt email did not get sent to {$user->email} ". $e->getMessage());
			}
		}
		// If a REP sold this
		else {
			@list($key,$exp) = explode('|',$user->key);

			// A new world order
			\Log::info('Creating new world order');
			$o = new Order();
			$o->user_id			= (!empty($csuser->sponsor_id)) ?  $csuser->sponsor_id : $user->id;
			$o->total_price		= Session::get('subtotal',0);
			$o->total_points	= Session::get('subtotal',0);
			$o->total_tax		= Session::get('tax',0);
			$o->total_shipping	= Session::get('shipcost',0);
			$o->details			= json_encode(array('orders'=>$sessiondata['orderdata'],'payments'=>$sessiondata['paymentdata']));
			$o->save();

			\Log::info('Creating new receipt');
			$inv = new Receipt();
			$inv->date_paid		= date('Y-m-d H:i:s');
			$inv->user_id		= $user->id;
			$inv->subtotal		= $sessiondata['subtotal'];
			$inv->tax			= floatval(Session::get('tax',0));
			$inv->balance		= 0;

			$inv->note			= isset($sessiondata['notes'])			? $sessiondata['notes']			: '';
			$inv->to_email		= isset($sessiondata['to_email'])		? $sessiondata['to_email']		: $user->email; 
			$inv->to_firstname  = isset($sessiondata['to_firstname'])	? $sessiondata['to_firstname']	: 'n/a';
			$inv->to_lastname	= isset($sessiondata['to_lastname'])	? $sessiondata['to_lastname']	: 'n/a';

			$inv->data			= json_encode($sessiondata['orderdata']);
			$inv->save();
			
			\Log::info('Assigning ledger items to this receipt');
			foreach($sessiondata['paymentdata'] as $txn) {
				\Log::info("\t TXN:".$txn->id.' GOES INTO RECEIPT '.$inv->id);
				$l = Ledger::where('transactionid', '=', $txn->id)->update(array('receipt_id'=>$inv->id));
			}

			// Deduct item quantity from inventory
			foreach ($invitems as $item) {
				\Log::info('ITEMS REMOVING: '.json_encode($item));
				if (isset($item['quantities'])) {
					$item['numOrder'] = array_shift($item['quantities']);
				}
				$request	= Request::create("llrapi/v1/remove-inventory/{$key}/{$item['id']}/{$item['numOrder']}/",'GET', array());
				$deduction	= json_decode(Route::dispatch($request)->getContent());
			}

			$data['notes']			= $sessiondata['notes'];
			$data['to_email']		= $inv->to_email;
			$data['to_firstname']	= $inv->to_firstname;
			$data['to_lastname']	= $inv->to_lastname;

			try { 
				$data['to_email'] = str_replace(' ','',preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',$data['to_email']));
				\Log::info("Dispatching original receipt to {$data['to_email']}");
				Mail::send('emails.standard', $data, function($message) use($user,$data) {
					$message->to($data['to_email'], "{$data['to_firstname']} {$data['to_lastname']}")
					->subject("Purchase receipt from {$user->first_name} {$user->last_name}")
					->from($user->email, "{$user->first_name} {$user->last_name}");
				});
			} catch (Exception $e) {
				\Log::error('Guess they decided against sending a receipt to their customer? '.$e->getMessage());
			}
			

			try { 
				\Log::info("Dispatching receipt copy to {$data['email']}");
				Mail::send('emails.standard', $data, function($message) use($user,$data) {
					$message->to($data['email'], "{$user->first_name} {$user->last_name}")
					->subject('Purchase receipt from '.Config::get('site.company_name'))
					->from(Config::get('site.default_from_email'), Config::get('site.company_name'));
				});
			} catch (Exception $e) {
				\Log::error("Woah, the rep  {$user->id} does not have an email address.. whoddathunk?: ".$e->getMessage());
			}


		}

		if (isset($sessiondata['consignment_purchase'])) {
			// Maybe send contgrat email to their upline?
			// If the session has an emailto person
			$data['email'] = $csuser->email;
			$user = $csuser;
		}

		Session::forget('customdiscount');
		Session::forget('emailto');
		Session::forget('repsale');
		Session::forget('orderdata');
		Session::forget('subtotal');
		Session::forget('tax');
		Session::forget('paidout');
		Session::forget('payments');
        Session::forget('paymentdata');
		Session::forget('previous_page_2');
		Session::forget('userbypass');
		Session::forget('note');
		Session::forget('to_email');
		Session::forget('to_firstname');
		Session::forget('to_lastname');
		Session::forget('invoice');
		Session::put('previous_page_2','/dashboard');

		return View::make('inventory.thankyoupage',compact('auth','invitems','sessiondata'));
	}

	public function cashpurchase() {
		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		$absamount	= abs(Input::get('amount'));
		$tax		= $this->getTax($absamount);
		$absamount = $this->totalCheck($absamount);

		$authinfo = new stdClass();
		$oldInput = Input::all();

		$invitems	= Session::get('orderdata');

		Session::put('notes',Input::get('notes'));
		Session::put('to_email',Input::get('to_email'));
		Session::put('to_firstname',Input::get('to_firstname'));
		Session::put('to_lastname',Input::get('to_lastname'));

		if (!Session::has('orderdata')) {
			return Redirect::route('dashboard');
		}

		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!Session::get('repsale')) {
			// For MWL user loginstuff
			$user = Config::get('site.mwl_username');
			$pass = Config::get('site.mwl_password');

			$authinfo = json_decode(App::make('ExternalAuthController')->midauth($user, $pass, true));
		}
		// This is the individual REP TID
		else {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->key = $key;
		}

		$purchaseInfo = array(
					'subtotal'		=>$absamount,
					'tax'			=>$tax,
					'cash'			=>1,
					'cart'			=>json_encode($invitems)
				);

		$ia = Input::all();
		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->key,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());
		Input::replace($ia);

		if (!$cardauth->error) {

			$this->addPayment($cardauth);

			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			return $this->finalizePurchase($cardauth, $invitems);
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth'));
	}

	public function achpurchase() {
		// This means the superadmin can set a user to "order for someone" 
		// more on this functionality later
		$acct = Input::get('account');
		if (Auth::user()->hasRole(array('Superadmin','Admin')) && Session::has('userbypass')) {
			Session::put('repsale',false);
			$checking = User::find(Session::get('userbypass'))->bankinfo->find($acct);
		}
		else {
			$checking =  Auth::user()->bankinfo->find($acct);
		}

		Session::put('notes',Input::get('notes'));
		Session::put('to_email',Input::get('to_email'));
		Session::put('to_firstname',Input::get('to_firstname'));
		Session::put('to_lastname',Input::get('to_lastname'));

		$absamount	= abs(Input::get('amount'));
		$tax		= $this->getTax($absamount);
		$absamount	= $this->totalCheck($absamount);

		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		$invitems	= Session::get('orderdata');

		$authinfo = new stdClass();
		$oldInput = Input::all();

		if (!Session::has('orderdata')) {
			return Redirect::route('dashboard');
		}

		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!Session::get('repsale')) {
			// For MWL user loginstuff
			$user = Config::get('site.mwl_username');
			$pass = Config::get('site.mwl_password');

			$authinfo = json_decode(App::make('ExternalAuthController')->midauth($user, $pass, true));
		}
		// This is the individual REP TID
		else {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->key = $key;
		}

		$purchaseInfo = array(
					'subtotal'		=>$absamount,
					'tax'			=>$tax,
					'accountname'	=>$checking->bank_name,
					'routing'		=>$checking->bank_routing,
					'account'		=>$checking->bank_account,
					'dlstate'		=>$checking->license_state,
					'dlnum'			=>$checking->license_number,
					'check'			=>1,
					'cart'			=>json_encode($invitems)
				);

		$ia = Input::all();
		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->key,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());
		Input::replace($ia);

		if (!$cardauth->error) {

			$this->addPayment($cardauth);

			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			return $this->finalizePurchase($cardauth, $invitems);
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth','checking'));
	}

	public function purchase(){

		// Holds the key
		$authinfo = new stdClass();

		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		if (!Input::get('invoice')) {
			$absamount	= abs(Input::get('amount'));
			$tax		= $this->getTax($absamount);
			$absamount	= $this->totalCheck($absamount);
			$invitems	= Session::get('orderdata');
		}
		// Load up the invoice
		else if (Session::has('invoice')) {
			$invoice	= Receipt::find(Session::get('invoice'));
			$invitems	= json_decode($invoice->data, true);
			$absamount	= $invoice->balance;
			$tax		= $invoice->tax;
			$user		= User::find($invoice->user_id);
			$authkey    = $user->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->key = $key;

			Session::put('repsale',true);
			Session::put('orderdata', $invitems);
		}

		Session::put('notes',Input::get('notes'));
		Session::put('to_email',Input::get('to_email'));
		Session::put('to_firstname',Input::get('to_firstname'));
		Session::put('to_lastname',Input::get('to_lastname'));

		$oldInput = Input::all();

		if (!Session::has('orderdata')) {
			return Redirect::route('dashboard');
		}

		$user = '';

		// MATT HACKERY - 
		// Watch for changes in mwl_password
		// It is no longer encoded in the site.php file. 
		if (!Session::get('repsale')) {
			$un = Config::get('site.mwl_username');
			$pw = Config::get('site.mwl_password');
			$authinfo = json_decode(App::make('ExternalAuthController')->midauth($un, $pw, true));
		}
		// This is the individual REP TID
		else if (!isset($authkey)) {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->key = $key;
		}

		$purchaseInfo = array(
					'subtotal'		=>$absamount,
					'tax'			=>$tax,
					'cardname'		=>$oldInput['accountname'],
					'cardnumber'	=>$oldInput['cardno'],
					'cardexp'		=>$oldInput['cardexp'],
					'cardcvv'		=>$oldInput['cvv'],
					'cardzip'		=>$oldInput['zip'],
					'cardaddress'	=>$oldInput['address'],
					'cart'			=>json_encode($invitems)
				);

		$ia = Input::all();
		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->key,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());
		Input::replace($ia);

		if (!$cardauth->error) {

			$this->addPayment($cardauth);

			// Update the invoice has been paid!
			if (isset($invoice)) {
				if (Input::get('shipping.address1')) { 
					$address = new Address();
					$address->address_1 = Input::get('shipping.address1');
					$address->address_2 = Input::get('shipping.address2');
					$address->city      = Input::get('shipping.city');
					$address->state     = Input::get('shipping.state');
					$address->zip       = Input::get('shipping.zip');
					$address->save();
					$invoice->address_id = $address->id;
				}


				$user = User::find($invoice->user_id);
				$invoice->balance	= $invoice->balance - $absamount;
				$invoice->date_paid = date('Y-m-d H:i:s');
				$invoice->save();

				// Send this on to finalizationerizer
				Session::put('repsale',true);
				Session::put('tax',$invoice->tax);
				Session::put('orderdata', json_decode($invoice->data,true));
				Session::put('subtotal', $invoice->subtotal);
				Session::put('paidout', $invoice->subtotal);

			}
			else { 
				// Perhaps check if its an invoice and redirect there with a balance?
				if (!$this->checkFinalSaleAmount($absamount)) {
					return Redirect::to('/inv/checkout');
				}
			}
			return $this->finalizePurchase($cardauth, $invitems, $user);
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth'));
	}
}
