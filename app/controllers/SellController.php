<?php

class SellController extends \BaseController {

    /**
     * Data only
     */
    public function getAllInventories(){
        
        return [
            'count' => Inventory::count(),
            'data' => Inventory::all()
        ];
    }

    /**
     * Process order checkout
     * 
     */
    public function checkout()
    {
            return View::make('sell.checkout');
    }

    
	/**
	 * Display a listing of inventories
	 *
	 * @return Response
	 */
	public function index()
	{
		$inventories = Inventory::all();

		return View::make('sell.index', compact('inventories'));
	}

	/**
	 * Show the form for creating a new sell
	 *
	 * @return Response
	 */
	public function create()
	{
		$sell = Inventory::all();

		return View::make('sell.create', compact('sell'));
	}

	/**
	 * Store a newly created sell in storage.
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

		return Redirect::route('sell.index');
	}

	/**
	 * Display the specified sell.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$sell = Inventory::findOrFail($id);

		return View::make('sell.show', compact('sell'));
	}

	/**
	 * Show the form for editing the specified sell.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        
		$sell = Inventory::find($id);
        if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
		    return View::make('sell.edit', compact('sell'));
        }
	}

	/**
	 * Update the specified sell in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sell = Inventory::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Inventory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$sell->update($data);

		return Redirect::route('inventories.index');
	}

	/**
	 * Remove the specified sell from storage.
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

	public function purchase(){
		$tax		= Session::get('tax');
		$subtotal	= Session::get('subtotal');
		$invitems	= Session::get('orderdata');

		$user = Config::get('site.mwl_username');
		$pass = Config::get('site.mwl_password');

		// MATT HACKERY - Watch for changes in password on ZERO account!!
		$oldInput = Input::all();
		$data = App::make('ExternalAuthController')->auth($user, 'test')->getContent();

		// $request	= Request::create('llrapi/v1/auth/0?pass=test','GET', array());
		$authinfo	= json_decode($data);

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

		if (!$cardauth->error) return View::make('sell.validpurchase',compact('cardauth','invitems'));
		else return View::make('sell.invalidpurchase',compact('cardauth'));
	}

    
}