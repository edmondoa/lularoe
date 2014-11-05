<?php 

class UserSitesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 200; $i++) {
			$userSite = array(
				'user_id' => 2000 + $i,
				'body' => $faker->text,
			);
			UserSite::create($userSite);
		}
	}

}
