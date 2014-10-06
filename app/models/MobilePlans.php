<?php 

class MobilePlans extends \Eloquent
{
    protected $table = 'mobile_plans';
	protected $fillable = array('name','blurb','description');


    public function store($input)
    {
        $mobilePlans = new MobilePlans;
        
        $mobilePlans->name = $input['name'];
        
        $mobilePlans->blurb = $input['blurb'];
        
        $mobilePlans->description = $input['description'];
        
        $mobilePlans->save();
    }
}