<?php

class postController extends \BaseController {

	/**
	 * Display a listing of posts
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$posts = Post::all();
			return View::make('post.index', compact('posts'));
		}
	}

	/**
	 * Show the form for creating a new post
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			return View::make('post.create');
		}
	}

	/**
	 * Store a newly created post in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			// validation
			$rules = [
				'title' => 'required',
				'short_title' => 'required',
				'url' => 'unique|required|alpha_dash',		
				'url' => 'required|alpha_dash|unique:posts'
			];
			$validator = Validator::make($data = Input::all(), Post::$rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
			// format checkbox values for database
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
			if ($data['public'] == 0 && $data['customers'] == 0 && $data['public'] == 0) $data['public'] = 1;
			if ($data['customers'] == 1 || $data['reps'] == 1) $data['public'] = 0;
			$data['public_header'] = isset($data['public_header']) ? 1 : 0;
			$data['public_footer'] = isset($data['public_footer']) ? 1 : 0;
			$data['back_office_header'] = isset($data['back_office_header']) ? 1 : 0;
			$data['back_office_footer'] = isset($data['back_office_footer']) ? 1 : 0;
			
			$post = Post::create($data);
			return Redirect::route('posts.edit', $post->id)->with('message', 'Post created.');
		}
	}

	/**
	 * Display the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($url)
	{
		$post = Post::where('url', $url)->first();
		$title = $post->title;
		if ($post->public) {
			return View::make('post.show', compact('post', 'title'));
		}
		elseif (Auth::check()) {
			if ($post->public || Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || (Auth::user()->hasRole(['Rep']) && $post->reps) || (Auth::user()->hasRole(['Customer']) && $post->customers)) {
				return View::make('post.show', compact('post', 'title'));
			}
		}
		else return "You don't have permission to view this post.";
	}

	/**
	 * Show the form for editing the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$post = Post::find($id);
			if ($post['customers'] || $post['reps']) $only_show_to = 'checked';
			else $only_show_to = '';
			return View::make('post.edit', compact('post', 'only_show_to'));
		}
	}

	/**
	 * Update the specified post in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			$post = Post::findOrFail($id);
			
			// validation
			$rules = [
				'title' => 'required',
				'short_title' => 'required',
				'url' => 'unique|required|alpha_dash',		
				'url' => 'required|alpha_dash|unique:posts,url,' . $post->id
			];
			$validator = Validator::make($data = Input::all(), Post::$rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
	
			strtolower($data['url']);
			
			// format checkbox values for database
			$data['public'] = isset($data['public']) ? 1 : 0;
			$data['customers'] = isset($data['customers']) ? 1 : 0;
			$data['reps'] = isset($data['reps']) ? 1 : 0;
			if ($data['public'] == 0 && $data['customers'] == 0 && $data['public'] == 0) $data['public'] = 1;
			if ($data['customers'] == 1 || $data['reps'] == 1) $data['public'] = 0;
			$data['public_header'] = isset($data['public_header']) ? 1 : 0;
			$data['public_footer'] = isset($data['public_footer']) ? 1 : 0;
			$data['back_office_header'] = isset($data['back_office_header']) ? 1 : 0;
			$data['back_office_footer'] = isset($data['back_office_footer']) ? 1 : 0;
			
			$post->update($data);
	
			return Redirect::back()->with('message', 'Post updated.');
		}
	}

	/**
	 * Remove the specified post from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			Post::destroy($id);
	
			return Redirect::route('posts.index')->with('message', 'Post deleted.');
		}
	}
	
	/**
	 * Remove posts.
	 */
	public function delete()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			foreach (Input::get('ids') as $id) {
				Post::destroy($id);
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('posts.index')->with('message', 'Posts deleted.');
			}
			else {
				return Redirect::back()->with('message', 'Post deleted.');
			}
		}
	}
	
	/**
	 * Diable posts.
	 */
	public function disable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			foreach (Input::get('ids') as $id) {
				Post::find($id)->update(['disabled' => 1]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('posts.index')->with('message', 'Posts disabled.');
			}
			else {
				return Redirect::back()->with('message', 'Post disabled.');
			}
		}
	}
	
	/**
	 * Enable posts.
	 */
	public function enable()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			foreach (Input::get('ids') as $id) {
				Post::find($id)->update(['disabled' => 0]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('posts.index')->with('message', 'Posts enabled.');
			}
			else {
				return Redirect::back()->with('message', 'Post enabled.');
			}
		}
	}

}