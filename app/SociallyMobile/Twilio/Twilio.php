<?php namespace SociallyMobile\Twilio;

//use Merchant;
use Auth;
use Config;

class Twilio {

	private $config;
	private $twilio_sid;
	private $twilio_token;
	private $twilio_number;

	public function __construct() {
		$twilio_sid = Config::get('twilio.sid');
		$twilio_token = Config::get('twilio.token');
		$twilio_number = Config::get('twilio.from');
		$config = [
			'sid'=>$twilio_sid,
			'token'=>$twilio_token
		];
		$this->config = $config;
	}

	public function message($to, $message, $from=null) {
		$twilio = $this->getTwilio();
		// Send SMS via Twilio SDK
		return $twilio->account->sms_messages->create(
			is_null($from) ? Config::get('twilio.from') : $from,
			$to,
			$message
		);
	}

	public function call($to, $url, $options=array(), $from=null) {
		$twilio = $this->getTwilio();
		// Create Call via Twilio SDK
		return $twilio->account->calls->create(
			is_null($from) ? Config::get('twilio.from') : $from,
			$to,
			$url,
			$options);
	}

	private function getTwilio()
	{
		return new \Services_Twilio($this->config['sid'], $this->config['token']);
	}
}