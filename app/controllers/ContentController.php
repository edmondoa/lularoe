<?php 

class ContentController extends \BaseController
{
	protected $content;

	public function __construct(Content $content)
	{
		$this->content = $content;
	}

	public function index()
	{
    	$contents = $this->content->all();
        $this->layout->content = \View::make('content.index', compact('contents'));
	}

	public function create()
	{
        $this->layout->content = \View::make('content.create');
	}

	public function store()
	{
        $this->content->store(\Input::only('page_id','section','content'));
        return \Redirect::route('content.index');
	}

	public function show($id)
	{
        $content = $this->content->find($id);
        $this->layout->content = \View::make('content.show')->with('content', $content);
	}

	public function edit($id)
	{
        $content = $this->content->find($id);
        $this->layout->content = \View::make('content.edit')->with('content', $content);
	}

	public function update($id)
	{
        $this->content->find($id)->update(\Input::only('page_id','section','content'));
        return \Redirect::route('content.show', $id);
	}

	public function destroy($id)
	{
        $this->content->destroy($id);
        return \Redirect::route('content.index');
	}

}
