<?php namespace SociallyMobile\Twilio;

use Illuminate\Support\ServiceProvider;
//use Twilio;

class TwilioServiceProvider extends ServiceProvider {

/**
* Indicates if loading of the provider is deferred.
*
* @var bool
*/
protected $defer = true;

/**
* Boot Method
*/
public function boot()
{
    //$this->package('SociallyMobile/twilio');
}

/**
* Register the service provider.
*
* @return void
*/
public function register()
{
        $this->app['twilio'] = $this->app->share(function($app)
        {
            return new Twilio();
        });

/*        // Register Twilio Test SMS Command
        $this->app['twilio.sms'] = $this->app->share(function($app) {
            return new Commands\TwilioSmsCommand();
        });

        // Register Twilio Test Call Command
        $this->app['twilio.call'] = $this->app->share(function($app) {
            return new Commands\TwilioCallCommand();
        });
        $this->commands(
            'twilio.sms',
            'twilio.call'
        );
*/

}

/**
* Get the services provided by the provider.
*
* @return array
*/
public function provides()
{
    return array('twilio');
}

}