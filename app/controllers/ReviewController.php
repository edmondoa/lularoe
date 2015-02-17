<?php

class ReviewController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllReviews(){
        $count = Review::count();
		$reviews = Review::all();
		foreach ($reviews as $review)
		{
			if (strtotime($review['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$review['new'] = 1;
			}
		}
		return [
            'count'=>$count,
            'data'=>$reviews
        ];
	}

	/**
	 * Display a listing of reviews
	 *
	 * @return Response
	 */
	public function index()
	{
		$reviews = Review::all();

		return View::make('review.index', compact('reviews'));
	}

	/**
	 * Show the form for creating a new review
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('review.create');
	}

	/**
	 * Store a newly created review in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Review::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Review::create($data);

		return Redirect::route('reviews.index')->with('message', 'Review created.');
	}

	/**
	 * Display the specified review.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$review = Review::findOrFail($id);

		return View::make('review.show', compact('review'));
	}

	/**
	 * Show the form for editing the specified review.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$review = Review::find($id);

		return View::make('review.edit', compact('review'));
	}

	/**
	 * Update the specified review in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$review = Review::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Review::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$review->update($data);

		return Redirect::route('reviews.show', $id)->with('message', 'Review updated.');
	}

	/**
	 * Remove the specified review from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Review::destroy($id);

		return Redirect::route('reviews.index')->with('message', 'Review deleted.');
	}
	
	/**
	 * Remove reviews.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Review::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('reviews.index')->with('message', 'Reviews deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Review deleted.');
		}
	}
	
	/**
	 * Diable reviews.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Review::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('reviews.index')->with('message', 'Reviews disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Review disabled.');
		}
	}
	
	/**
	 * Enable reviews.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Review::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('reviews.index')->with('message', 'Reviews enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Review enabled.');
		}
	}

}