<?php 

class EmailRecipientsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$emailRecipients = array(
				'sms_message_id' => $faker->randomDigitNotNull,
				'user_id' => $faker->randomDigitNotNull,
			);
			EmailRecipients::create($emailRecipients);
		}
	}

}
