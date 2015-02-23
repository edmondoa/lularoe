<?php

class ProductCategory extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'product_categories';
	protected $fillable = array('name','parent_id','disabled');

	public function getParentNameAttribute() {
		if ($this->parent_id != 0) {
			$parent = ProductCategory::find($this->parent_id);
			return $parent->name;
		}
		else return '';
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record', 'parent_name');

}