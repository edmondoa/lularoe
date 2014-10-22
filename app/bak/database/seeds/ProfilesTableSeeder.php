<?php 

class ProfilesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$profile = array(
				'public_name' => $faker->word,
				'public_content' => $faker->text,
				'receive_company_email' => $faker->boolean,
				'receive_company_sms' => $faker->boolean,
				'receive_upline_email' => $faker->boolean,
				'receive_upline_sms' => $faker->boolean,
				'receive_downline_email' => $faker->boolean,
				'receive_downline_sms' => $faker->boolean,
				'disabled' => $faker->boolean,
			);
			Profile::create($profile);
		}
	}

}
