<?php 

class LeadsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 20; $i++) {
			$lead = array(
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'email' => $faker->email,
				'gender' => $faker->randomElement(['F','M']),
				'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
				'phone' => $faker->numerify($string = '##########'),
				'sponsor_id' => 10004,
				'opportunity_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Lead::create($lead);
		}
	}

}
