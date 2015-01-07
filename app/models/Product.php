<?php

class Product extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
<<<<<<< HEAD
		'name' => 'required',
		'price' => 'required|numeric',
		'category_id' => 'required|integer'
=======
	// 'title' => 'required'
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
	];

	// Don't forget to fill this array    
	protected $table = 'products';
<<<<<<< HEAD
	protected $fillable = array('name','blurb','description','price','quantity','category_id','image','disabled');
=======
	protected $fillable = array('name','blurb','description','price','quantity','category_id','disabled');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
<<<<<<< HEAD
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
	
	public function getImageSmAttribute() {
		$image_sm = explode('.', $this->image);
		if (isset($image_sm[1])) return $image_sm[0] . '-sm.' . $image_sm[1];
		else return '';	
	}
	
	protected $appends = array('new_record', 'category_name', 'image_sm');
=======
	protected $appends = array('new_record');
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5

}