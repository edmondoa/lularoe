<?php 

class SmsMessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$smsMessages = array(
				'body' => $faker->word,
			);
			SmsMessages::create($smsMessages);
		}
	}

}
