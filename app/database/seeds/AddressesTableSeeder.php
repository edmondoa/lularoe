<?php 

class AddressesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$addresses = array(
				'address_1' => $faker->word,
				'address_2' => $faker->word,
				'city' => $faker->city,
				'state' => $faker->state,
				'addressable_id' => $faker->randomDigitNotNull,
				'zip' => $faker->randomDigitNotNull,
			);
			Addresses::create($addresses);
		}
	}

}
