<?php 

class UsersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$user = array(
				'first_name' => $faker->word,
				'last_name' => $faker->word,
				'email' => $faker->email,
				'password' => \Hash::make('password'),
				'gender' => $faker->word,
				'key' => str_random(20),
				'dob' => $faker->date,
				'phone' => $faker->randomDigitNotNull,
				'role_id' => $faker->randomDigitNotNull,
				'sponsor_id' => $faker->randomDigitNotNull,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			User::create($user);
		}
		User::create([
			"first_name" => 'John',
			"last_name" => 'Doe',
			"email" => 'sgashler@controlpad.com',
			"password" => Hash::make('password2'),
			"gender" => 'Male',
			'key' => str_random(20),
			"phone" => '8014274607',
			"dob" => '1972-08-28',
			'phone' => $faker->randomDigitNotNull,
			'role_id' => $faker->randomDigitNotNull,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
		]);
	}

}
