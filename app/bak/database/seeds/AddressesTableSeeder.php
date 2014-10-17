<?php 

class AddressesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$address = array(
				'address_1' => $faker->word,
				'address_2' => $faker->word,
				'city' => $faker->city,
				'state' => $faker->state,
				'addressable_id' => $i,
				'zip' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Address::create($address);
		}
	}

}
