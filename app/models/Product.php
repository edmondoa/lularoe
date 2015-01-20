<?php

class Product extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'price' => 'required|numeric',
		'category_id' => 'required|integer'
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
		if (!isset($this->category)) App::abort(404,'Cannot display products - No categories defined!');
		return $this->category->name;
	}
	
	public function getImageSmAttribute() {
		$image_sm = explode('.', $this->image);
		if (isset($image_sm[1])) return $image_sm[0] . '-sm.' . $image_sm[1];
		else return '';	
	}
	
	protected $appends = array('new_record', 'category_name', 'image_sm');

}
