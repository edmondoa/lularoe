<?php 

class Pages extends \Eloquent
{
    protected $table = 'pages';
	protected $fillable = array('name','url','type','opportunity');


    public function store($input)
    {
        $pages = new Pages;
        
        $pages->name = $input['name'];
        
        $pages->url = $input['url'];
        
        $pages->type = $input['type'];
        
        $pages->opportunity = $input['opportunity'];
        
        $pages->save();
    }
}