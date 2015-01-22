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
		//Cache::forget($key);
		//return 'fetching cache:'.$key;
		//if(Cache::has($key)) return "CACHED:".date('H:i:s')." - ".Cache::get($key);
		if(Cache::has($key)) return Cache::get($key);
	}

	public function put(Route $route, Request $request, $response) {
		//return 'Putting Cache';
		//if($response->content instanceof Illuminate\Http\Response\Redirect) return;
		$key = $this->makeCacheKey($request->url());

		//if ((!Cache::has($key))&&(!$response->getContent() instanceof Illuminate\Http\Response\Redirect)&&(strlen($response->getContent()) > 5)) Cache::put($key, $response->getContent(),Config::get('site.cache_length'));
		//if ((!Cache::has($key))&&(null !== $response->getContent())&&(strlen($response->getContent()) > 5)) Cache::put($key, $response->getContent()." - ".date('H:i:s',strtotime(' + 1 minute')),\Config::get('site.cache_length'));
		if ((!Cache::has($key))&&(null !== $response->getContent())&&(!$response->getContent() instanceof Illuminate\Http\Response\Redirect)&&(strlen($response->getContent()) > 5)) Cache::put($key, $response->getContent(),10);
	}

	protected function makeCacheKey($url) {
		return 'route_'.Str::slug($url);
	}
}
