<?php namespace LLR\Twilio;

use Illuminate\Support\Facades\Facade;

class TwilioFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'twilio'; }

}