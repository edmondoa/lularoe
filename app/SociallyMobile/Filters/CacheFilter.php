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
		\Log::info('Accessed CacheFetch function');
		//Cache::forget($key);
		//return 'fetching cache:'.$key;
		//if(Cache::has($key)) return "CACHED:".date('H:i:s')." - ".Cache::get($key);
		if(Cache::has($key)) return Cache::get($key);

	}

	public function put(Route $route, Request $request, Response $response) {
		//return 'Putting Cache';
		\Log::info('Accessed CachePut function');
		$key = $this->makeCacheKey($request->url());
		//if ((!Cache::has($key))&&(null !== $response->getContent())&&(strlen($response->getContent()) > 5)) Cache::put($key, $response->getContent()." - ".date('H:i:s',strtotime(' + 1 minute')),\Config::get('site.cache_length'));
		if ((!Cache::has($key))&&(null !== $response->getContent())&&(strlen($response->getContent()) > 5)) Cache::put($key, $response->getContent(),10);
	}

	protected function makeCacheKey($url) {
		return 'route_'.Str::slug($url);
	}
}
