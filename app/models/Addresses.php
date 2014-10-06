<?php 

class Addresses extends \Eloquent
{
    protected $table = 'addresses';
	protected $fillable = array('address_1','address_2','city','state','addressable_id','zip');


    public function store($input)
    {
        $addresses = new Addresses;
        
        $addresses->address_1 = $input['address_1'];
        
        $addresses->address_2 = $input['address_2'];
        
        $addresses->city = $input['city'];
        
        $addresses->state = $input['state'];
        
        $addresses->addressable_id = $input['addressable_id'];
        
        $addresses->zip = $input['zip'];
        
        $addresses->save();
    }
}