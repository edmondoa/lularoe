<?php 

class EmailMessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$emailMessages = array(
				'subject' => $faker->word,
				'body' => $faker->text,
			);
			EmailMessages::create($emailMessages);
		}
	}

}
