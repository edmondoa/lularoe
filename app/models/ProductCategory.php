<?php 

class ProductCategory extends \Eloquent
{
    protected $table = 'product_categories';
	protected $fillable = array('name','disabled');


}