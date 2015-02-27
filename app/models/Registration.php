<?php

class Registration extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
	
	];

	// Don't forget to fill this array
	protected $table = 'registrations';
	protected $fillable = [
		'registerable_id',
		'registerable_type',
		'person_id',
		'person_type',
		'status',
	];

}