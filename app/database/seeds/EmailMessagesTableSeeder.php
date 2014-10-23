<?php 

class EmailMessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$emailMessage = array(
				'sender_id' => $i + 2000,
				'recipient_id' => $faker->randomDigitNotNull,
				'subject' => $faker->text,
				'body' => $faker->text,
				'disabled' => $faker->boolean,
			);
			EmailMessage::create($emailMessage);
		}
	}

}
