<?php 

class UserTestsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$userTest = array(
				'first_name' => $faker->word,
				'last_name' => $faker->word,
				'email' => $faker->email,
				'password' => \Hash::make('password'),
				'gender' => $faker->word,
				'key' => $faker->word,
				'code' => $faker->word,
				'dob' => $faker->date,
				'phone' => $faker->randomDigitNotNull,
				'role_id' => $faker->randomDigitNotNull,
				'sponsor_id' => $faker->randomDigitNotNull,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			UserTest::create($userTest);
		}
	}

}
