<?php

class InventoryController extends \BaseController {

    /**
     * Data only
     */
    public function getAllInventories(){
        
        return [
            'count' => Inventory::count(),
            'data' => Inventory::all()
        ];
    }

    public function getTax($value,$viaRequest=true,$doTemplate=false){
        // Corona California tax
        $data = file_get_contents('https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/33.8667,-117.5667/get?saleamount='.$value);
        $tax = json_decode($data);
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
        $tax = $this->getTax($inittotal,false,true);
        Session::put('subtotal',$inittotal);
        Session::put('tax',$tax);
        return View::make('inventory.checkout',compact('orders','inittotal','tax','subtotal'));    
    }

    
	/**
	 * Display a listing of inventories
	 *
	 * @return Response
	 */
	public function index()
	{
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
            return View::make('inventory.repsales');
    }

	public function cashpurchase() {
		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		$repsale	= Input::get('repsale', 1);  // This is almost always a rep sale

		$tax		= Session::get('tax');
		$subtotal	= Session::get('subtotal');
		$invitems	= Session::get('orderdata');


		$authinfo = new stdClass();
		$oldInput = Input::all();

		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!$repsale) {
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
					'subtotal'		=>$subtotal,
					'tax'			=>$tax,
					'cash'			=>1,
					'cart'			=>json_encode($invitems)
				);

		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());

		if (!$cardauth->error) {
			if ($repsale) {
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

		// If it IS a rep sale, 
		// Deduct inventory, if not, ADD inventory
		$repsale	= Input::get('repsale', 1);  // This is almost always a rep sale

		$tax		= Session::get('tax');
		$subtotal	= Session::get('subtotal');
		$invitems	= Session::get('orderdata');


		$authinfo = new stdClass();
		$oldInput = Input::all();


		// MATT HACKERY - Watch for changes in password on ZERO account!!
		if (!$repsale) {
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
					'subtotal'		=>$subtotal,
					'tax'			=>$tax,
					'accountname'	=>$checking->bank_name,
					'routing'		=>$checking->bank_routing,
					'account'		=>$checking->bank_account,
					'dlstate'		=>$checking->license_state,
					'dlnum'			=>$checking->license_number,
					'check'			=>1,
					'cart'			=>json_encode($invitems)
				);

		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());

		if (!$cardauth->error) {
			if ($repsale) {
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
		$repsale	= Input::get('repsale', 0); 

		$tax		= Session::get('tax');
		$subtotal	= Session::get('subtotal');
		$invitems	= Session::get('orderdata');


		$authinfo = new stdClass();
		$oldInput = Input::all();

		// MATT HACKERY - 
		// Watch for changes in mwl_password
		// It is no longer encoded in the site.php file. 
		if (!$repsale) {
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
					'subtotal'		=>$subtotal,
					'tax'			=>$tax,
					'cardname'		=>$oldInput['accountname'],
					'cardnumber'	=>$oldInput['cardno'],
					'cardexp'		=>$oldInput['cardexp'],
					'cardcvv'		=>$oldInput['cvv'],
					'cardzip'		=>$oldInput['zip'],
					'cardaddress'	=>$oldInput['address'],
					'cart'			=>json_encode($invitems)
				);
		
		Input::replace($purchaseInfo);
		$request	= Request::create('llrapi/v1/purchase/'.$authinfo->mwl,'GET', array());
		$cardauth	= json_decode(Route::dispatch($request)->getContent());

		if (!$cardauth->error) {
			if ($repsale) {
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
