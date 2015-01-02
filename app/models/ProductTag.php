<?php

class ProductTag extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'name' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'product_tags';
	protected $fillable = array('name','taggable_id','product_category_id','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}