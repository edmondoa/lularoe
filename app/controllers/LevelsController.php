<?php 

class LevelsController extends \BaseController
{
	protected $levels;

	public function __construct(Levels $levels)
	{
		$this->levels = $levels;
	}

	public function index()
	{
    	$levels = $this->levels->all();
        $this->layout->content = \View::make('levels.index', compact('levels'));
	}

	public function create()
	{
        $this->layout->content = \View::make('levels.create');
	}

	public function store()
	{
        $this->levels->store(\Input::only('user_id','ancestor_id','level'));
        return \Redirect::route('levels.index');
	}

	public function show($id)
	{
        $levels = $this->levels->find($id);
        $this->layout->content = \View::make('levels.show')->with('levels', $levels);
	}

	public function edit($id)
	{
        $levels = $this->levels->find($id);
        $this->layout->content = \View::make('levels.edit')->with('levels', $levels);
	}

	public function update($id)
	{
        $this->levels->find($id)->update(\Input::only('user_id','ancestor_id','level'));
        return \Redirect::route('levels.show', $id);
	}

	public function destroy($id)
	{
        $this->levels->destroy($id);
        return \Redirect::route('levels.index');
	}

}
