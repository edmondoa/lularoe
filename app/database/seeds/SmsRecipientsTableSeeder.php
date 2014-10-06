<?php 

class SmsRecipientsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$smsRecipients = array(
				'email_message_id' => $faker->randomDigitNotNull,
				'user_id' => $faker->randomDigitNotNull,
			);
			SmsRecipients::create($smsRecipients);
		}
	}

}
