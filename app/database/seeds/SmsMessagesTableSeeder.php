<?php 

class SmsMessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$smsMessage = array(
				'sender_id' => $faker->randomDigitNotNull,
				'recipient_id' => $faker->randomDigitNotNull,
				'body' => $faker->text,
				'disabled' => $faker->boolean,
			);
			SmsMessage::create($smsMessage);
		}
	}

}
