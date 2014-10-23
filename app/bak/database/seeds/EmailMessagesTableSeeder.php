<?php 

class EmailMessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$emailMessage = array(
				'sender_id' => $faker->randomDigitNotNull,
				'recipient_id' => $faker->randomDigitNotNull,
				'subject' => $faker->text,
				'body' => $faker->text,
				'disabled' => $faker->boolean,
			);
			EmailMessage::create($emailMessage);
		}
	}

}
