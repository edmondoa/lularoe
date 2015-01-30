<?php namespace LLR\Filters;

use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;
use Cache;
use Config;

class CacheFilter {

	public function fetch(Route $route, Request $request) {
		$key = $this->makeCacheKey($request->url());
		//Cache::forget($key);
		//return $key;
		if(Cache::has($key))
		{
			//return "Fetching:".$key;
			$cached_content = Cache::get($key);
			if(strlen($cached_content) > 50)
			{
				//echo $cached_content."".strlen($cached_content);
				//exit;
				return $cached_content;
			}
			else
			{
				\Log::info("########################################## Cache was too short:".$key);
				Cache::forget($key);
			}
		}
	}

	public function put(Route $route, Request $request, Response $response) {
		$key = $this->makeCacheKey($request->url());
		//return $key;
		if ((!Cache::has($key))&&(null !== $response->getContent())&&(!$response->getContent() instanceof Illuminate\Http\Response\Redirect)&&(strlen($response->getContent()) > 50)) Cache::put($key, $response->getContent(),10);
	}

	protected function makeCacheKey($url) {
		return 'route_'.Str::slug($url);
	}
}
