<?php 

class AttachmentsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$attachment = array(
				'type' => $faker->word,
				'url' => $faker->url,
				'user_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Attachment::create($attachment);
		}
	}

}
