<?php

class InventoryController extends \BaseController {

	// HARDCODED for now, definitely pullable from a DB though
	// Discounts are SUBTRACTIVE, meaning the total is combined together
	// then SUBTRACTED from the total
    public $discounts = array(
			['title'=>'Incentive Discount','math'=>array('op'=>'*','n'=>.05)],
			['title'=>'$5 Bump','math'=>array('op'=>'=','n'=>5.00)]
		);

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

		// Do the MATHS
		foreach ($this->discounts as $discount) {
			// I <3 Eval .. NOT!
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
		$discounted['total'] = $dctotal;

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
		if (Session::get('repsale'))  { 
			// Corona California tax
			$data = file_get_contents('https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/33.8667,-117.5667/get?saleamount='.$value);
			$tax = json_decode($data);
		}
		else { // No tax calculated (or flat tax!)
			$tax = new stdClass();
			$tax->Tax = 0;
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
die($discounts);
        $tax		= 0;//$this->getTax($inittotal);

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
		$grandTotal = floatVal($tax) + floatVal($sub);

		if ($absamount > ($grandTotal - Session::get('paidout'))) 
			$absamount = $grandTotal - Session::get('paidout');

		return($absamount);
	}

	public function checkFinalSaleAmount($saleAmount) {

		// Get the full order amount currently pending purchase
		$tax = Session::get('tax');
		$sub = Session::get('subtotal');
		$disc = 0; // discounts

		$disc = $this->getDiscounts($sub,true);

		$grandTotal = floatVal($tax) + floatVal($sub) - floatVal($disc);

		// If the sale amount is still less than the grand total
		if (Session::get('paidout') < $grandTotal) {
			$diffAmount = floatVal($grandTotal) - floatVal($saleAmount);

			$po = Session::get('paidout', 0);
			Session::put('paidout',floatval($po) + floatval($saleAmount));

			return false; // Not done paying YET!
		}
		// else we are done paying
		else return true; 
	}


	// Consignment purchase
	public function conspurchase() {
		// Make sure we have enough consignment to pull this off
		$cons 		= Auth::user()->consignment;
		$absamount	= abs(Input::get('amount'));
		$absamount = $this->totalCheck($absamount);

		if ($cons <= 0) {
			$cardauth->status = 'No consignment is currently available to you.';
			return View::make('inventory.invalidpurchase',compact('cardauth'));
		}
		
		if ($cons < $absamount) { 
			// Set it to maximum $cons
			Input::replace(array('amount'=>$cons));
		}

		// Deduct inventory, if not, ADD inventory
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

			$data = App::make('ExternalAuthController')->auth($user, $pass)->getContent();
			$authinfo	= json_decode($data);
		}
		// This is the individual REP TID
		else {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->mwl = $key;
		}

		$purchaseInfo = array(
					'subtotal'		=>$absamount,
					'tax'			=>$tax,
					'cash'			=>2,
					'cart'			=>json_encode($invitems)
				);

		
		$ia = Input::all();
		Input::replace($purchaseInfo);
		//$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		//$cardauth	= json_decode(Route::dispatch($request)->getContent());
		$cardauth	= json_decode('{ "error":false }');
		Input::replace($ia);

		if (!$cardauth->error) {
			$user = Auth::user();
			$user->consignment = $user->consignment - floatval($absamount);
			$user->save();

			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			if (Session::get('repsale')) {
				// Deduct item quantity from inventory
				foreach ($invitems as $item) {
					$request	= Request::create("llrapi/v1/remove-inventory/{$authinfo->mwl}/{$item['id']}/{$item['numOrder']}/",'GET', array());
					$deduction	= json_decode(Route::dispatch($request)->getContent());
				}
			}
			return View::make('inventory.validpurchase',compact('cardauth','invitems'));
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth'));
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

		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!Session::get('repsale')) {
			// For MWL user loginstuff
			$user = Config::get('site.mwl_username');
			$pass = Config::get('site.mwl_password');

			$data = App::make('ExternalAuthController')->auth($user, $pass)->getContent();
			$authinfo	= json_decode($data);
		}
		// This is the individual REP TID
		else {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->mwl = $key;
		}

		$purchaseInfo = array(
					'subtotal'		=>$absamount,
					'tax'			=>$tax,
					'cash'			=>1,
					'cart'			=>json_encode($invitems)
				);

		$ia = Input::all();
		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());
		Input::replace($ia);

		if (!$cardauth->error) {
			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			if (Session::get('repsale')) {
				// Deduct item quantity from inventory
				foreach ($invitems as $item) {
					$request	= Request::create("llrapi/v1/remove-inventory/{$authinfo->mwl}/{$item['id']}/{$item['numOrder']}/",'GET', array());
					$deduction	= json_decode(Route::dispatch($request)->getContent());
				}
			}
			return View::make('inventory.validpurchase',compact('cardauth','invitems'));
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth'));
	}

	public function achpurchase() {
		$checking = Auth::user()->bankinfo->find(Input::get('account'));

		$absamount	= abs(Input::get('amount'));
		$tax		= $this->getTax($absamount);
		$absamount	= $this->totalCheck($absamount);

		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		$invitems	= Session::get('orderdata');

		$authinfo = new stdClass();
		$oldInput = Input::all();


		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!Session::get('repsale')) {
			// For MWL user loginstuff
			$user = Config::get('site.mwl_username');
			$pass = Config::get('site.mwl_password');

			$data = App::make('ExternalAuthController')->auth($user, $pass)->getContent();
			$authinfo	= json_decode($data);
		}
		// This is the individual REP TID
		else {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->mwl = $key;
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
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());
		Input::replace($ia);

		if (!$cardauth->error) {
			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			if (Session::get('repsale')) {
				// Deduct item quantity from inventory
				foreach ($invitems as $item) {
					$request	= Request::create("llrapi/v1/remove-inventory/{$authinfo->mwl}/{$item['id']}/{$item['numOrder']}/",'GET', array());
					$deduction	= json_decode(Route::dispatch($request)->getContent());
				}
			}
			return View::make('inventory.validpurchase',compact('cardauth','invitems'));
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth','checking'));
	}

	public function purchase(){
		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		$absamount	= abs(Input::get('amount'));
		$tax		= $this->getTax($absamount);
		$absamount = $this->totalCheck($absamount);

		$invitems	= Session::get('orderdata');

		$authinfo = new stdClass();
		$oldInput = Input::all();

		// MATT HACKERY - 
		// Watch for changes in mwl_password
		// It is no longer encoded in the site.php file. 
		if (!Session::get('repsale')) {
			$user = Config::get('site.mwl_username');
			$pass = Config::get('site.mwl_password');
			$data = App::make('ExternalAuthController')->auth($user, $pass)->getContent();
			$authinfo	= json_decode($data);
		}
		// This is the individual REP TID
		else {
			$authkey = Auth::user()->key;
			@list($key,$exp) = explode('|',$authkey);
			$authinfo->mwl = $key;
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
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());
		Input::replace($ia);

		if (!$cardauth->error) {
			if (!$this->checkFinalSaleAmount($absamount)) {
				return Redirect::to('/inv/checkout');
			}
			if (Session::get('repsale')) {
				// Deduct item quantity from inventory
				foreach ($invitems as $item) {
					$request	= Request::create("llrapi/v1/remove-inventory/{$authinfo->mwl}/{$item['id']}/{$item['numOrder']}/",'GET', array());
					$deduction	= json_decode(Route::dispatch($request)->getContent());
				}
			}
			return View::make('inventory.validpurchase',compact('cardauth','invitems'));
		}
		else return View::make('inventory.invalidpurchase',compact('cardauth'));
	}
    
}
