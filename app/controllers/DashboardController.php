<?php 

class DashboardController extends \BaseController
{

	public function index()
	{
		// rep dashboard
		if (Auth::user()->hasRole(['Editor', 'Rep'])) {
			$user = User::findOrFail(Auth::user()->id);
			$sponsor = User::find($user->id)->sponsor;
			$children = User::find($user->id)->children;
			$ranks = User::find($user->id)->ranks;
			$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
			$new_downline = User::find(Auth::user()->id)->new_descendants()->orderBy('created_at', 'DESC')->get()->take(10);
			$new_downline_count_30 = User::find($user->id)->new_descendants_count_30();
			// recent post
			$recent_post = Post::where('Reps', 1)->where('publish_date', '<', date('Y-m-d h:i:s'))->orWhere('created_at', '<', date('Y-m-d h:i:s'))->orderBy('publish_date')->orderBy('created_at')->get()->take(1);
			if (isset($recent_post[0])) {
				$recent_post = $recent_post[0];
				if ($recent_post->publish_date > 0) $recent_post->date = $recent_post->publish_date;
				else $recent_post->date = $recent_post->created_at;
				$recent_post->date = date('M d Y', strtotime($recent_post->date));
				if ($recent_post->description != '') $recent_post->content = $recent_post->description;
				else $recent_post->content = limit_words($recent_post->body,25) . ' ...';
			}
			return View::make('dashboard.rep', compact('user', 'sponsor', 'children', 'ranks', 'beta_service_link', 'new_downline', 'new_downline_count_30', 'recent_post'));
		}
		
		// admin dashboard
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$user = User::findOrFail(Auth::user()->id);
			$reps = User::all()->count();
			$beta_service_link = SiteConfig::where('key', 'beta-service-link')->first();
			$new_downline = User::find(Auth::user()->id)->new_descendants()->orderBy('created_at', 'DESC')->get()->take(10);
			$new_downline_count_30 = User::find($user->id)->new_descendants_count_30();
			// recent post
			$recent_post = Post::where('publish_date', '<', date('Y-m-d h:i:s'))->orWhere('created_at', '<', date('Y-m-d h:i:s'))->orderBy('publish_date')->orderBy('created_at')->get()->take(1);
			if (isset($recent_post[0])) {
				$recent_post = $recent_post[0];
				if ($recent_post->publish_date > 0) $recent_post->date = $recent_post->publish_date;
				else $recent_post->date = $recent_post->created_at;
				$recent_post->date = date('M d Y', strtotime($recent_post->date));
				if ($recent_post->description != '') $recent_post->content = $recent_post->description;
				else $recent_post->content = limit_words($recent_post->body,25) . ' ...';
			}
			return View::make('dashboard.admin', compact('user', 'reps', 'beta_service_link', 'new_downline', 'new_downline_count_30', 'recent_post'));
		}
	}
	
	public function settings()
	{
		$addresses = User::find(Auth::user()->id)->addresses;
		return View::make('dashboard.settings', compact('addresses'));
	}
	
}
