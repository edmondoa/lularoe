<?php

class DatabaseSeeder extends Seeder {
	protected $faker;

	public function getFaker()
	{
		if(empty($this->faker)) {
			$this->faker = Faker\Factory::create();
		}

		return $this->faker;
	}



	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('UsersTableSeeder');
	}

}
