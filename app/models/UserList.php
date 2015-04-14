<?php

class UserList extends \Eloquent 
{
  
    protected $table = 'users';
    protected $hidden = [
        'password',
        'role',
        'created_at',
        'consignment',
        'hide_billing_address',
        'hide_email',
        'hide_shipping_address',
        'image',
        'key',
        'min_commission',
        'mobile_plan_id',
        'original_sponsor_id',
        'phone_sms',
        'remember_token',
        'subscribed',
        'subscription_notice',
        'verified',
        'password',
        'hasSignUp'
    ];
    
    
    ##############################################################################################
    # append custom Attribs
    ##############################################################################################
    
    protected $appends = [
        'descendant_count',
        'front_line_count',
        'rank_id', 
        'rank_name',
        'role_name',
        'public_gender',
        'public_dob',
        'public_email',
        'public_phone',
        'formatted_phone'
    ];
    
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function descendants() {
        return $this -> belongsToMany('UserList', 'levels', 'ancestor_id','user_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_descendants')->withPivot('level');
    }

    public function frontline() {
        return $this -> hasMany('UserList', 'sponsor_id', 'id');
    }

    public function role() {
        return $this->belongsTo('Role');
    }
  
    
    /*
    public function userSite() {
        return $this->belongsTo('UserSite');
    }*/

    public function ranks() {
        return $this->belongsToMany('Rank','rank_user','user_id')->orderBy('rank_user.id', 'DESC')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_ranks')->withPivot('created_at');
    }
    
    public function currentRank() {
        //return;
        return $this->ranks()->orderBy('rank_user.created_at', 'DESC')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_rank2')->first();
    }
    /**/
    public function descendantsCountRelation()
    {
        return $this->descendants()->selectRaw('ancestor_id, count(*) as count')->groupBy('ancestor_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_desc_count')->first();
    }
    /**/
    public function frontlineCountRelation()
    {
        return $this->frontline()->selectRaw('sponsor_id, count(*) as count')->groupBy('sponsor_id')->remember(Config::get('site.cache_query_length'),'user_'.$this->id.'_frontline_count')->first();
    }

    /**/
    
    ##############################################################################################
    # Custom Attributes
    ##############################################################################################
    /**/
    public function getFrontLineCountAttribute() {
        return (int) (isset($this->frontlineCountRelation()->count))?$this->frontlineCountRelation()->count:0;
    }
    /*
    public function getPersonallySponsoredCountAttribute() {
        return (int) (isset($this->personallySponsoredCountRelation()->count))?$this->personallySponsoredCountRelation()->count:0;
    }
    */

    public function getPublicGenderAttribute() {
        if(!Auth::check()) return;
        if (isset($this->gender)) {
            if ($this->id == Auth::user()->id || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9) return $this->gender;
            return ($this->hide_gender != true)?$this->gender:'';
        }
    }
   /* */
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
    /**/
    
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
    
    /**/
    public function getRoleNameAttribute() {
        if(isset($this->role->name))
        {
            return $this->role->name;
        }
        return false;
    }
    
    /*    
    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }*/
    
    public function getFormattedPhoneAttribute($value)
    {
        if (!empty($this->phone)) {
            return substr($this->phone, 0, 3)."-".substr($this->phone, 3, 3)."-".substr($this->phone,6);
        }
    
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D+/', '', $value);
    }

    ##############################################################################################
    # role and permissions
    ##############################################################################################
    /*
    public function hasRole($key) {
        if(!is_array($key)) return false;
        if(!isset($this->role->name)) return false;
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

    */
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