<?php 

class RolesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$role = array(
				'name' => $faker->name,
				'disabled' => $faker->boolean,
			);
			Role::create($role);
		}
	}

}
