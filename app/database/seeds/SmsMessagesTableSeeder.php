<?php 

class SmsMessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$smsMessage = array(
				'sender_id' => $i + 2001,
				'recipient_id' => $i + 2000,
				'body' => $faker->text,
				'disabled' => $faker->boolean,
			);
			SmsMessage::create($smsMessage);
		}
	}

}
