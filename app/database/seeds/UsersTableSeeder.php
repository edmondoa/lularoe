<?php 

class UsersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$users = array(
				'first_name' => $faker->word,
				'last_name' => $faker->word,
				'email' => $faker->email,
				'password' => \Hash::make('password'),
				'key' => $faker->word,
				'code' => $faker->word,
				'phone' => $faker->randomDigitNotNull,
				'role_id' => $faker->randomDigitNotNull,
				'sponsor_id' => $faker->randomDigitNotNull,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
			);
			Users::create($users);
		}
	}

}
