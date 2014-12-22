<?php namespace SociallyMobile\Filters;

use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;
use Cache;
use Config;

class CacheFilter {

	public function fetch(Route $route, Request $request) {
		//return 'Fetching Cache';
		$key = $this->makeCacheKey($request->url());
		if(Cache::has($key)) return Cache::get($key);
	}

	public function put(Route $route, Request $request, Response $response) {
		//return 'Putting Cache';
		$key = $this->makeCacheKey($request->url());
		if (!Cache::has($key)) Cache::put($key, $response->getContent(),Config::get('site.cache_length'));
	}

	protected function makeCacheKey($url) {
		return 'route_'.Str::slug($url);
	}
}
