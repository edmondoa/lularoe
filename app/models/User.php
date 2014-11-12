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
		//'sponsor_id' => 'required',
		//'password' => 'confirmed'
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
		'role_id',
		'key',
		'image',
		'disabled',
		'created_at',
		'updated_at'
	];

	use UserTrait, RemindableTrait;

	public function addresses()
	{
		return $this->hasMany('Address', 'addressable_id', 'id');
	}

	public function sponsor() {
		return $this -> belongsTo('User');
	}
	
	public function children() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id');
	}

	public function descendants() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->withPivot('level');
	}

	public function frontline() {
		return $this -> hasMany('User', 'sponsor_id', 'id');
	}

	public function role() {
		return $this->belongsTo('Role');
	}
	
	public function userSite() {
		return $this->belongsTo('UserSite');
	}

	public function ranks() {
		return $this->belongsToMany('Rank')->orderBy('rank_user.id', 'DESC')->withPivot('created_at');
	}
	
	public function currentRank() {
		return $this->belongsToMany('Rank')->orderBy('rank_user.id', 'DESC')->first();
	}
	
	public function descendantsCountRelation()
    {
        return $this->descendants()->selectRaw('ancestor_id, count(*) as count')->groupBy('ancestor_id')->first();
    }

	public function frontlineCountRelation()
    {
        return $this->frontline()->selectRaw('sponsor_id, count(*) as count')->groupBy('sponsor_id')->first();
    }

	public function getFrontLineCountAttribute() {
		return (int) (isset($this->frontlineCountRelation()->count))?$this->frontlineCountRelation()->count:0;
	}

	public function getDescendantCountAttribute() {
		return (int) (isset($this->descendantsCountRelation()->count))?$this->descendantsCountRelation()->count:0;
	}

	public function getRankNameAttribute() {
		if(isset($this->currentRank()->name))
		{
			return $this->currentRank()->name;
		}
		return false;
	}
	
	public function getRankIdAttribute() {
		if(isset($this->currentRank()->id))
		{
			return $this->currentRank()->id;
		}
		return false;
	}
	
	public function getRoleNameAttribute() {
		if(isset($this->role->name))
		{
			return $this->role->name;
		}
		return false;
	}

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	public function getFormattedPhoneAttribute($value)
	{
		return substr($this->attributes['phone'], 0, 3)."-".substr($this->attributes['phone'], 3, 3)."-".substr($this->attributes['phone'],6);
	}
	
	protected $appends = array('descendant_count','front_line_count','rank_name', 'rank_id', 'role_name', 'new_record', 'formatted_phone');

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

	public function hasRepInDownline($repId) {
		if(!Auth::check()) return false;
		$rep = $this->descendants()->where('levels.user_id',$repId)->first();
		return ($rep)?true:false;
	}
}
