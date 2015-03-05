<?php

class Tag extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	// 'title' => 'required'
	];

	// Don't forget to fill this array    
	protected $table = 'tags';
	protected $fillable = array('name','taggable_type','taggable_id');

}