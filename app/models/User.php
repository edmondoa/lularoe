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
		'email' => 'required|email|unique:users',
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

	##############################################################################################
	# Relationships
	##############################################################################################
	
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
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->remember(5,'user_'.$this->id.'_descendants')->withPivot('level');
	}

	public function leads() {
		return $this -> hasMany('Lead', 'sponsor_id', 'id');
	}

	public function frontline() {
		return $this -> hasMany('User', 'sponsor_id', 'id');
	}

	public function role() {
		return $this->belongsTo('Role');
	}
	
	public function plans() {
		return $this->belongsToMany('Product','plans');
	}
	
	public function payments() {
		return $this->hasMany('Payment');
	}
	
	public function userSite() {
		return $this->belongsTo('UserSite');
	}

	public function ranks() {
		return $this->belongsToMany('Rank')->orderBy('rank_user.id', 'DESC')->remember(5,'user_'.$this->id.'_ranks')->withPivot('created_at');
	}
	
	public function currentRank() {
		//return;
		return $this->belongsToMany('Rank')->orderBy('rank_user.id', 'DESC')->remember(5,'user_'.$this->id.'_rank')->first();
	}
	
	public function descendantsCountRelation()
	{
		return $this->descendants()->selectRaw('ancestor_id, count(*) as count')->groupBy('ancestor_id')->remember(5,'user_'.$this->id.'_desc_count')->first();
	}

	public function frontlineCountRelation()
	{
		return $this->frontline()->selectRaw('sponsor_id, count(*) as count')->groupBy('sponsor_id')->remember(5,'user_'.$this->id.'_frontline_count')->first();
	}

	public function orgVolumeRelation()
	{
		return $this->payments()->whereRaw('MONTH(payments.created_at)=MONTH(CURRENT_DATE) and YEAR(payments.created_at)=YEAR(CURRENT_DATE)')->selectRaw('payments.user_id, SUM(payments.amount) as volume')->groupBy('payments.user_id' )->remember(5)->first();
		}

	public function new_descendants() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->where('users.created_at', '>=', date('Y-m-d H:i:s',strtotime(' 30 days ago')));
	}
	
	##############################################################################################
	# Custom Attributes
	##############################################################################################
	
	public function getFrontLineCountAttribute() {
		return (int) (isset($this->frontlineCountRelation()->count))?$this->frontlineCountRelation()->count:0;
	}


	public function getPublicGenderAttribute() {
		if(!Auth::check()) return;
		if (isset($this->gender)) {
			if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $this->gender;
			return ($this->hide_gender != true)?$this->gender:'';
		}
	}

	public function getPublicDobAttribute() {
		if(!Auth::check()) return;
		if (isset($this->dob)) {
			if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $this->dob;
			return ($this->hide_dob != true)?$this->dob:'';
		}
	}

	public function getPublicEmailAttribute() {
		if(!Auth::check()) return;
		if (isset($this->email)) {
			if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $this->email;
			return ($this->hide_email != true)?$this->email:'';
		}
	}

	public function getPublicPhoneAttribute() {
		if(!Auth::check()) return;
		if (isset($this->phone)) {
			if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $this->phone;
			return ($this->hide_phone != true)?$this->phone:'';
		}
	}

	// public function getPublicBillingAddressAttribute() {
		// if (isset($this->addresses)) {
			// foreach ($this->addresses as $address) {
				// if ($address->label == 'Billing') {
					// if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $address;
					// return ($this->hide_billing_address != true)?$address:'';
				// }
			// }
		// }
	// }
// 	
	// public function getPublicShippingAddressAttribute() {
		// if (isset($this->addresses)) {
			// foreach ($this->addresses as $address) {
				// if ($address->label == 'Billing') {
					// if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $address;
					// return ($this->hide_shipping_address != true)?$address:'';
				// }
			// }
		// }
	// }
	
	public function getDescendantCountAttribute() {
		return (int) (isset($this->descendantsCountRelation()->count))?$this->descendantsCountRelation()->count:0;
	}


	public function getAccountBalanceAttribute()
	{
	    return (double) $this->payments()->whereRaw('MONTH(created_at)=MONTH(CURDATE())')->remember(5,'user_'.$this->id.'_balance')->sum('amount');    
	}

	public function getVolumeAttribute() {
		return false;
		return (double) (isset($this->orgVolumeRelation()->volume))?$this->orgVolumeRelation()->remember(5,'user_'.$this->id.'_volume')->volume:0;
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
	
	public function getFullNameAttribute() {
		return $this->first_name . ' ' . $this->last_name;
	}
	
	public function getFormattedPhoneAttribute($value)
	{
		return substr($this->attributes['phone'], 0, 3)."-".substr($this->attributes['phone'], 3, 3)."-".substr($this->attributes['phone'],6);
	}
	


	##############################################################################################
	# append custom Attribs
	##############################################################################################
	
	protected $appends = array('descendant_count','front_line_count','rank_name', 'rank_id', 'role_name', 'new_record', 'formatted_phone','volume','account_balance', 'public_gender', 'public_dob', 'full_name', 'public_email', 'public_phone'/*, 'public_billing_address', 'public_shipping_address'*/);

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	##############################################################################################
	# Password reminder methods
	##############################################################################################
	
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
	
	##############################################################################################
	# role and permissions
	##############################################################################################
	
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
