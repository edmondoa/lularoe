<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	public $timestamps = false;

	public static $rules = [
		'email' => 'required|unique:users,email',
		'first_name' => 'required|alpha',
		'last_name' => 'required|alpha',
		'phone' => 'required',
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
		'public_id',
		'role_id'
	];

	use UserTrait, RemindableTrait;

	// public function addresses() {
		// return $this -> morphMany('Address', 'addressable');
	// }
	
	public function address()
	{
		return $this->hasMany('Address', 'addressable_id', 'id');
	}
	
	public function sponsor() {
		return $this -> belongsTo('User', 'sponsor_id', 'id');
	}
	
	public function children() {
		return $this -> hasMany('User', 'sponsor_id', 'id');
	}

	public function role() {
		return $this->belongsTo('Role');
	}


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
	public function hasRole($key) {
	    if(!is_array($key)) return false;
	    foreach($key as $role){
		    if($this->role->name === $role){
		    	return true;
			}
	    }
	    return false;
	}
}
