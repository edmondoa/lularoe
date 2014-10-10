<?php

class State extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'abbr' => 'required|alpha|digits:2',
		'full_name' => 'required|alpha'
	];

	// Don't forget to fill this array
	protected $fillable = ['abbr','full_name'];

}