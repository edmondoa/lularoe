<?php 

class PartiesTableSeeder extends DatabaseSeeder
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 100; $i++) {
			$min_time = time() - 2629743; // 1 month ago
			$max_time = time() + 2629743; // 1 month from today
			$start_time = $faker->numberBetween($min = $min_time, $max = $max_time);
			$party = array(
				'name' => $faker->sentence($nbWords = 6),
				'description' => $faker->text,
				'date_start' => $start_time,
				'date_end' => $faker->numberBetween($min = $start_time, $max = $start_time + 86400),
				'organizer_id' => $faker->numberBetween($min = 2001, $max = 2010),
				'host_id' => $faker->numberBetween($min = 2001, $max = 2010),
				'public' => $faker->boolean,
				'timezone' => $faker->timezone,
				'disabled' => $faker->boolean
			);
			Party::create($party);
			$address = array(
				'address_1' => $faker->streetAddress,
				'address_2' => $faker->secondaryAddress,
				'city' => $faker->city,
				'state' => strtoupper($faker->stateAbbr),
				'addressable_id' => $i,
				'addressable_type' => 'Party',
				'zip' => $faker->postcode,
				'label' => $faker->sentence($nbWords = 4),
				'disabled' => $faker->boolean,
			);
			Address::create($address);
		}
	}

}