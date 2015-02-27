<?php

class Attachment extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [

	];

	// Don't forget to fill this array    
	protected $table = 'attachments';
	protected $fillable = array(
		'attachable_type',
		'attachable_id',
		'media_id',
		'featured'
	);

}