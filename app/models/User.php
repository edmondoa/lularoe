<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	public $timestamps = false;
	//public $eighteenyearsago = date('Y-m-d',strtotime('18 years ago'));
	public static $rules = [
		'email' => 'required|unique:users,email',
		'first_name' => 'required|alpha',
		'last_name' => 'required|alpha',
		'phone' => 'required|numeric|digits:10',
		'gender' => 'required|in:M,F',
		'dob' => 'required|date',
		'sponsor_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [
		'sponsor_id',
		'email',
		'password',
		'first_name',
		'last_name',
		'phone',
		'gender',
		'dob',
		'public_id'
	];

	use UserTrait, RemindableTrait;

	public function addresses() {
		return $this -> morphMany('Address', 'addressable');
	}
	
	public function sponsor() {
		return $this -> belongsTo('User', 'sponsor_id', 'id');
	}
	
	public function children() {
		return $this -> hasMany('User', 'id', 'sponsor_id');
	}

	public function role() {
		return $this->belongsTo('Role');
	}

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}
