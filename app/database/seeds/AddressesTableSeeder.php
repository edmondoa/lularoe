<?php 

class AddressesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		for($i = 1; $i <= 20; $i++) {
			for ($x = 0; $x <= 1; $x ++) {
				if ($x == 0) $label = 'Billing';
				if ($x == 1) $label = 'Shipping';
				$address = array(
					'address_1' => $faker->streetAddress,
					'address_2' => $faker->secondaryAddress,
					'city' => $faker->city,
					'state' => strtoupper($faker->stateAbbr),
					'addressable_id' => $i + 2000,
					'addressable_type' => 'User',
					'zip' => $faker->postcode,
					'label' => $label,
					'disabled' => $faker->boolean,
				);
				Address::create($address);
			}
		}
	}

}
