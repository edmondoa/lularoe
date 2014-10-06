<?php 

class PaymentsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$payments = array(
				'user_id' => $faker->randomDigitNotNull,
				'transaction_id' => $faker->randomDigitNotNull,
				'amount' => $faker->randomDigitNotNull,
				'tender' => $faker->word,
				'details' => $faker->text,
			);
			Payments::create($payments);
		}
	}

}
