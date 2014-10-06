<?php 

class Content extends \Eloquent
{
    protected $table = 'contents';
	protected $fillable = array('page_id','section','content');


    public function store($input)
    {
        $content = new Content;
        
        $content->page_id = $input['page_id'];
        
        $content->section = $input['section'];
        
        $content->content = $input['content'];
        
        $content->save();
    }
}