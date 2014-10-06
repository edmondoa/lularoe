<?php 

class ReviewsController extends \BaseController
{
	protected $reviews;

	public function __construct(Reviews $reviews)
	{
		$this->reviews = $reviews;
	}

	public function index()
	{
    	$reviews = $this->reviews->all();
        $this->layout->content = \View::make('reviews.index', compact('reviews'));
	}

	public function create()
	{
        $this->layout->content = \View::make('reviews.create');
	}

	public function store()
	{
        $this->reviews->store(\Input::only('product_id','rating','comment'));
        return \Redirect::route('reviews.index');
	}

	public function show($id)
	{
        $reviews = $this->reviews->find($id);
        $this->layout->content = \View::make('reviews.show')->with('reviews', $reviews);
	}

	public function edit($id)
	{
        $reviews = $this->reviews->find($id);
        $this->layout->content = \View::make('reviews.edit')->with('reviews', $reviews);
	}

	public function update($id)
	{
        $this->reviews->find($id)->update(\Input::only('product_id','rating','comment'));
        return \Redirect::route('reviews.show', $id);
	}

	public function destroy($id)
	{
        $this->reviews->destroy($id);
        return \Redirect::route('reviews.index');
	}

}
