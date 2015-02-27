<?php

class Order extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public static function boot() {
		parent::boot();
		static::creating(function($order) { }); // returning false will cancel the operation
		static::created(function($order) { });
		static::updating(function($order) { }); // returning false will cancel the operation
		static::updated(function($order) { });
		static::saving(function($order) { });  // returning false will cancel the operation
		static::saved(function($order) { });
		static::deleting(function($order) { }); // returning false will cancel the operation
		static::deleted(function($order) { });    
	}
	
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function lines() {
		return $this->hasMany('Orderline');
	}
	
	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	protected $appends = array('new_record');

}