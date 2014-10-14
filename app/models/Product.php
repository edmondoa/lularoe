<?php 

class Product extends \Eloquent
{
    protected $table = 'products';
	protected $fillable = array('name','blurb','description','price','quantity','category_id','disabled');


}