<?php 

class AddressesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 20; $i++) {
			for ($x = rand(0,1); $x !== 1; $x = rand(0,1)) {
				if ($x == 0) $address_type = 'Billing';
				if ($x == 1) $address_type = 'Shipping';
				$address = array(
				
					'address_1' => $faker->streetAddress,
					'address_2' => $faker->secondaryAddress,
					'city' => $faker->city,
					'state' => strtoupper($faker->stateAbbr),
					'addressable_id' => $i + 2000,
					'zip' => $faker->postcode,
					'addressable_type' => $address_type,
					'disabled' => $faker->boolean,
				);
				Address::create($address);
			}
		}
	}

}
