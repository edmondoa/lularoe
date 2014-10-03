<?php 

class UsersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$users = array(
				'first' => $faker->word,
				'last' => $faker->word,
				'email' => $faker->email,
				'password' => \Hash::make('password'),
			);
			Users::create($users);
		}
	}

}
