<?php 

class Images extends \Eloquent
{
    protected $table = 'images';
	protected $fillable = array('type','url');


    public function store($input)
    {
        $images = new Images;
        
        $images->type = $input['type'];
        
        $images->url = $input['url'];
        
        $images->save();
    }
}