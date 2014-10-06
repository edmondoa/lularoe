<?php 

class RolesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$roles = array(
				'name' => $faker->name,
			);
			Roles::create($roles);
		}
	}

}
