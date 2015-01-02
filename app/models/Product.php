<?php

class Product extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'products';
	protected $fillable = array('name','blurb','description','price','quantity','category_id','image','disabled');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	/***************
	 * Relationships
	 ***************/
	
	public function category() {
		return $this->belongsTo('ProductCategory', 'category_id', 'id');
	}
	
	public function tags() {
		return $this->hasMany('ProductTag', 'taggable_id', 'id');
	}
	
	public function getCategoryNameAttribute() {
		return $this->category->name;
	}
	
	protected $appends = array('new_record', 'category_name');

}