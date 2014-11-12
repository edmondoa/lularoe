<?php 

class UserSitesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 200; $i++) {
			$userSite = array(
				'user_id' => 2000 + $i,
				'title' => $faker->sentence($nbWords = 6),
				'body' => $faker->text,
				'display_phone' => 1
			);
			UserSite::create($userSite);
		}
		$userSite = array(
			'user_id' => 10004,
			'title' => $faker->sentence($nbWords = 6),
			'body' => $faker->text,
			'display_phone' => 1
		);
		UserSite::create($userSite);
	}

}
