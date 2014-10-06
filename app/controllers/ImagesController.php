<?php 

class ImagesController extends \BaseController
{
	protected $images;

	public function __construct(Images $images)
	{
		$this->images = $images;
	}

	public function index()
	{
    	$images = $this->images->all();
        $this->layout->content = \View::make('images.index', compact('images'));
	}

	public function create()
	{
        $this->layout->content = \View::make('images.create');
	}

	public function store()
	{
        $this->images->store(\Input::only('type','url'));
        return \Redirect::route('images.index');
	}

	public function show($id)
	{
        $images = $this->images->find($id);
        $this->layout->content = \View::make('images.show')->with('images', $images);
	}

	public function edit($id)
	{
        $images = $this->images->find($id);
        $this->layout->content = \View::make('images.edit')->with('images', $images);
	}

	public function update($id)
	{
        $this->images->find($id)->update(\Input::only('type','url'));
        return \Redirect::route('images.show', $id);
	}

	public function destroy($id)
	{
        $this->images->destroy($id);
        return \Redirect::route('images.index');
	}

}
