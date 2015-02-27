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
	// public $timestamps = false;


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
		'original_sponsor_id',
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
	# append custom Attribs
	##############################################################################################
	
	protected $appends = [
		'descendant_count',
		'front_line_count',
		'personally_sponsored_count',
		'rank_name',
		'rank_id',
		'role_name',
		'new_record',
		'formatted_phone',
		//'volume',
		//'account_balance',
		'public_gender',
		'public_dob',
		'full_name',
		'public_email',
		'formatted_created_at',
		'public_phone', 
		'level',
		//'public_billing_address',
		//'public_shipping_address'
	];
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
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_descendants')->withPivot('level');
	}

	public function descendants_sm() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->select(['users.id'])->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_descendants_sm')->withPivot('level');
	}

	public function ancestors() {
		return $this -> belongsToMany('User', 'levels', 'user_id','ancestor_id')->orderBy('level','desc')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_ancestors')->whereNotNull('sponsor_id')->withPivot('level');
	}

	public function leads() {
		return $this -> hasMany('Lead', 'sponsor_id', 'id');
	}

	public function frontline() {
		return $this -> hasMany('User', 'sponsor_id', 'id');
	}

	public function personally_sponsored() {
		return $this -> hasMany('User', 'original_sponsor_id', 'id');
	}

	public function role() {
		return $this->belongsTo('Role');
	}
	
	public function plans() {
		return $this->belongsToMany('Product','plans');
	}
	
	public function orders() {
		return $this->hasMany('Order');
	}
	
	public function stats() {
		return $this->hasMany('Userstat');
	}
	
	public function stats_to_date() {
		return $this->hasMany('Userstat')->where('commission_period',date('Y-m-00'))->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_stats')->first();
	}
	
	public function userSite() {
		return $this->belongsTo('UserSite');
	}

	public function ranks() {
		return $this->belongsToMany('Rank')->orderBy('rank_user.id', 'DESC')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_ranks')->withPivot('created_at');
	}
	
	public function currentRank() {
		//return;
		return $this->ranks()->orderBy('rank_user.created_at', 'DESC')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_rank2')->first();
	}
	
	public function descendantsCountRelation()
	{
		return $this->descendants()->selectRaw('ancestor_id, count(*) as count')->groupBy('ancestor_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_desc_count')->first();
	}

	public function frontlineCountRelation()
	{
		return $this->frontline()->selectRaw('sponsor_id, count(*) as count')->groupBy('sponsor_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_frontline_count')->first();
	}

	public function personallySponsoredCountRelation()
	{
		return $this->personally_sponsored()->selectRaw('sponsor_id, count(*) as count')->groupBy('sponsor_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_personally_sponsored_count')->first();
	}

	public function orgVolumeRelation()
	{
		return $this->payments()->whereRaw('MONTH(payments.created_at)=MONTH(CURRENT_DATE) and YEAR(payments.created_at)=YEAR(CURRENT_DATE)')->selectRaw('payments.user_id, SUM(payments.amount) as volume')->groupBy('payments.user_id' )->remember(5)->first();
		}

	public function new_descendants() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->where('users.created_at', '>=', date('Y-m-d H:i:s',strtotime('30 days ago')));
	}
	
	public function new_descendants_count_30() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->where('users.created_at', '>=', date('Y-m-d H:i:s',strtotime('30 days ago')))->count();
	}
	
	public function new_descendants_count_7() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->where('users.created_at', '>=', date('Y-m-d H:i:s',strtotime('7 days ago')))->count();
	}

	public function new_descendants_count_1() {
		return $this -> belongsToMany('User', 'levels', 'ancestor_id','user_id')->where('users.created_at', '>=', date('Y-m-d H:i:s',strtotime('1 day ago')))->count();
	}
	
	##############################################################################################
	# Custom Attributes
	##############################################################################################
	
	public function getFrontLineCountAttribute() {
		return (int) (isset($this->frontlineCountRelation()->count))?$this->frontlineCountRelation()->count:0;
	}

	public function getPersonallySponsoredCountAttribute() {
		return (int) (isset($this->personallySponsoredCountRelation()->count))?$this->personallySponsoredCountRelation()->count:0;
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
			if ($this->hide_phone != true) {
				return substr($this->phone, 0, 3)."-".substr($this->phone, 3, 3)."-".substr($this->phone,6);
			}
			else {
				return '';
			}
		}
	}
	
	public function getDescendantCountAttribute() {
		return (int) (isset($this->descendantsCountRelation()->count))?$this->descendantsCountRelation()->count:0;
	}

/*	
public function getAccountBalanceAttribute()
	{
	    return (double) $this->orders()->whereRaw('MONTH(created_at)=MONTH(CURDATE())')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_balance')->sum('total_price');    
	}

	public function getPVAttribute()
	{
	    return (double) $this->orders()->whereRaw('MONTH(created_at)=MONTH(CURDATE())')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_balance')->sum('total_points');    
	}

	public function getVolumeAttribute() {
		return false;
		return (double) (isset($this->orgVolumeRelation()->volume))?$this->orgVolumeRelation()->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_volume')->volume:0;
	}
*/	
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
		if (!empty($this->phone)) {
			return substr($this->phone, 0, 3)."-".substr($this->phone, 3, 3)."-".substr($this->phone,6);
		}
	
	}
	

	public function getFormattedCreatedAtAttribute($value)
	{
		return date('M d Y, h:i a', strtotime($this->created_at));
	}

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D+/', '', $value);
    }

	public function getLevelAttribute()
	{
		return (isset($this->pivot->level))?$this->pivot->level:null;
	}

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
		$descendency = Level::where('user_id',$repId)->where('ancestor_id',$this->id)->first();
		return ($descendency)?true:false;
	}

	public function sumOrgOrders() {
		if(!Auth::check()) return false;
		$total = 0;
		foreach($this->descendants as $descendant)
		{
			$total += $descendant->account_balance;
		}
		//exit;
		return $total;
	}

	public function clearUserCache(){
		if(isset($this->id)){
			$forgotten_keys = [];
			$keys = [
				'user_'.$this->id.'_role',
				'user_'.$this->id.'_descendants',
				'user_'.$this->id.'_ancestors',
				'user_'.$this->id.'_roles',
				'user_'.$this->id.'_stats',
				'user_'.$this->id.'_ranks',
				'user_'.$this->id.'_rank',
				'user_'.$this->id.'_plan',
				'user_'.$this->id.'_rank2',
				'user_'.$this->id.'_desc_count',
				'user_'.$this->id.'_frontline_count',
				'user_'.$this->id.'_personally_sponsored_count',
				'user_'.$this->id.'_org_volume',
				'user_'.$this->id.'_balance',
				'user_'.$this->id.'_volume',
				'route_'.Str::slug(action('DataOnlyController@getAllDownline',$this->id)),
				'route_'.Str::slug(action('DataOnlyController@getImmediateDownline',$this->id)),
			];
			//return $keys;
			foreach($keys as $key)
			{
				if(Cache::has($key))
				{
					Cache::forget($key);
					$forgotten_keys[] = $key;
				}
			}
			return true;
		}
		else
		{
			return "no id set";
		}
	}
    
}
