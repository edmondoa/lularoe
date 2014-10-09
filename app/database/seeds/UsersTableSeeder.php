<?php 

class UsersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		//$number_founders = $faker->numberBetween(3,5);
		for($i = 1; $i <= 10; $i++) {
			//$founder_id = $i;
			//Level_1
			$users = array(
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'email' => $faker->safeEmail,
				'password' => \Hash::make('password2'),
				'key' => $faker->word
				'phone' => $faker->numerify($string = '##########'),
				'dob' => $faker->date,
				'phone' => $faker->randomDigitNotNull,
				'role_id' => $faker->randomDigitNotNull,
				'sponsor_id' => 0,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
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
			'disabled' => $faker->boolean,
		]);
	}

}
