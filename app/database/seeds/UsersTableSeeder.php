<?php 

class UsersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		for($i = 1; $i <= 10; $i++) {
			$users = array(
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'email' => $faker->safeEmail,
				'password' => \Hash::make('password2'),
				'key' => $faker->word,
				'phone' => $faker->numerify($string = '##########'),
				'dob' => $faker->date,
				'phone' => $faker->randomDigitNotNull,
				'role_id' => $faker->randomDigitNotNull,
				'sponsor_id' => $faker->randomDigitNotNull,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
		}
		User::create([
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'customer@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 1,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'rep@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 2,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'editor@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 3,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'admin@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 4,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'superadmin@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 5,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'first_name' => 'Steve',
			'last_name' => 'Gashler',
			'email' => 'sgashler@controlpad.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 5,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'first_name' => 'Jake',
			'last_name' => 'Barlow',
			'email' => 'jbarlow@controlpad.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'phone' => $faker->randomDigitNotNull,
			'role_id' => 5,
			'sponsor_id' => $faker->randomDigitNotNull,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
	}

}
