<?php 

class PagesController extends \BaseController
{
	protected $pages;

	public function __construct(Pages $pages)
	{
		$this->pages = $pages;
	}

	public function index()
	{
    	$pages = $this->pages->all();
        $this->layout->content = \View::make('pages.index', compact('pages'));
	}

	public function create()
	{
        $this->layout->content = \View::make('pages.create');
	}

	public function store()
	{
        $this->pages->store(\Input::only('name','url','type','opportunity'));
        return \Redirect::route('pages.index');
	}

	public function show($id)
	{
        $pages = $this->pages->find($id);
        $this->layout->content = \View::make('pages.show')->with('pages', $pages);
	}

	public function edit($id)
	{
        $pages = $this->pages->find($id);
        $this->layout->content = \View::make('pages.edit')->with('pages', $pages);
	}

	public function update($id)
	{
        $this->pages->find($id)->update(\Input::only('name','url','type','opportunity'));
        return \Redirect::route('pages.show', $id);
	}

	public function destroy($id)
	{
        $this->pages->destroy($id);
        return \Redirect::route('pages.index');
	}

}
