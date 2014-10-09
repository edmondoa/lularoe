<?php 

class Address extends \Eloquent
{
    protected $table = 'addresses';
	protected $fillable = array('address_1','address_2','city','state','addressable_id','zip','disabled');


}