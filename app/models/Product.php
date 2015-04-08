<?php

class Product extends \Eloquent
{

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'rep_price' => 'required|numeric',
		'category_id' => 'required|integer'
	];

	// Don't forget to fill this array    
	protected $table = 'products';
	protected $fillable = array('sku','name','blurb','description','price','retail_price','rep_price','quantity','category_id','image','points_value','make','model','size','disabled','user_id');

	public function getNewRecordAttribute() {
		return (strtotime($this->created_at) >= (time() - Config::get('site.new_time_frame') ))?true:false;
	}
	
	/*##############################################################################################
	Relationships	
	##############################################################################################*/
			
	public function category() {
		return $this->belongsTo('ProductCategory', 'category_id', 'id');
	}
	
	public function tags() {
		return $this->hasMany('ProductTag', 'taggable_id', 'id');
	}
	
	public function getCategoryNameAttribute() {
		if (isset($this->category->name)) {
			return $this->category->name;
		}
		else return '';
	}
	
	public function getImageSmAttribute() {
		$image_sm = explode('.', $this->image);
		if (isset($image_sm[1])) return $image_sm[0] . '-sm.' . $image_sm[1];
		else return '';
	}
	
	public function getBarCodeAttribute() {
		if (isset($this->barcode_image)) {
			if (!empty($this->sku)) { 
				if(empty($this->barcode_image))
				{
					$this->barcode_image = \DNS1D::getBarcodePNGPath($this->sku, "C128",3,75);
					$this->save();
				}
				elseif(!is_file(public_path().$this->barcode_image))
				{
					$this->barcode_image = \DNS1D::getBarcodePNGPath($this->sku, "C128",3,75);
					$this->save();
				}
				return $this->barcode_image;
			}
		}
		return '';
	}
	
    public function items() {
		return $this->belongsToMany('Item', 'product_item', 'product_id', 'item_id');
    }
	
	protected $appends = array('new_record', 'category_name', 'image_sm','bar_code');

}
