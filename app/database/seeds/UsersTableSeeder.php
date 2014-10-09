<?php 

class UsersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		$number_founders = $faker->numberBetween(10,45);
		for($i = 1; $i <= $number_founders; $i++) {
			//$founder_id = $i;
			//Level_1
			$users = array(
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'email' => $faker->safeEmail,
				'password' => \Hash::make('password2'),
				'key' => $faker->word,
				'code' => $faker->word,
				'phone' => $faker->numerify($string = '##########'),
				'role_id' => $faker->randomDigitNotNull,
				'sponsor_id' => 0,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
			);
			$founder = Users::create($users);
			$number_level_two = $faker->numberBetween(0,10);
			for($i_two = 1; $i_two <= $number_level_two; $i_two++) {
				//level_2
				$users = array(
					'first_name' => $faker->firstName,
					'last_name' => $faker->lastName,
					'email' => $faker->safeEmail,
					'password' => \Hash::make('password2'),
					'key' => $faker->word,
					'code' => $faker->word,
					'phone' => $faker->numerify($string = '##########'),
					'role_id' => $faker->randomDigitNotNull,
					'sponsor_id' => $founder->id,
					'mobile_plan_id' => $faker->randomDigitNotNull,
					'min_commission' => $faker->randomDigitNotNull,
				);
				$level_two = Users::create($users);
				$number_level_three = $faker->numberBetween(0,9);
				for($i_three = 1; $i_three <= $number_level_three; $i_three++) {
					//level_3
					$users = array(
						'first_name' => $faker->firstName,
						'last_name' => $faker->lastName,
						'email' => $faker->safeEmail,
						'password' => \Hash::make('password2'),
						'key' => $faker->word,
						'code' => $faker->word,
						'phone' => $faker->numerify($string = '##########'),
						'role_id' => $faker->randomDigitNotNull,
						'sponsor_id' => $level_two->id,
						'mobile_plan_id' => $faker->randomDigitNotNull,
						'min_commission' => $faker->randomDigitNotNull,
					);
					$level_three = Users::create($users);
					$number_level_four = $faker->numberBetween(0,8);
					for($i_four = 1; $i_four <= $number_level_four; $i_four++) {
						//level_4
						$users = array(
							'first_name' => $faker->firstName,
							'last_name' => $faker->lastName,
							'email' => $faker->safeEmail,
							'password' => \Hash::make('password2'),
							'key' => $faker->word,
							'code' => $faker->word,
							'phone' => $faker->numerify($string = '##########'),
							'role_id' => $faker->randomDigitNotNull,
							'sponsor_id' => $level_three->id,
							'mobile_plan_id' => $faker->randomDigitNotNull,
							'min_commission' => $faker->randomDigitNotNull,
						);
						$level_four = Users::create($users);
						$number_level_five = $faker->numberBetween(0,7);
						for($i_five = 1; $i_five <= $number_level_five; $i_five++) {
							//level_5
							$users = array(
								'first_name' => $faker->firstName,
								'last_name' => $faker->lastName,
								'email' => $faker->safeEmail,
								'password' => \Hash::make('password2'),
								'key' => $faker->word,
								'code' => $faker->word,
								'phone' => $faker->numerify($string = '##########'),
								'role_id' => $faker->randomDigitNotNull,
								'sponsor_id' => $level_four->id,
								'mobile_plan_id' => $faker->randomDigitNotNull,
								'min_commission' => $faker->randomDigitNotNull,
							);
							$level_five = Users::create($users);
							$number_level_six = $faker->numberBetween(0,6);
							for($i_six = 1; $i_six <= $number_level_six; $i_six++) {
								//level_6
								$users = array(
									'first_name' => $faker->firstName,
									'last_name' => $faker->lastName,
									'email' => $faker->safeEmail,
									'password' => \Hash::make('password2'),
									'key' => $faker->word,
									'code' => $faker->word,
									'phone' => $faker->numerify($string = '##########'),
									'role_id' => $faker->randomDigitNotNull,
									'sponsor_id' => $level_five->id,
									'mobile_plan_id' => $faker->randomDigitNotNull,
									'min_commission' => $faker->randomDigitNotNull,
								);
								$level_six = Users::create($users);
								$number_level_seven = $faker->numberBetween(0,5);
								for($i_seven = 1; $i_seven <= $number_level_seven; $i_seven++) {
									//level_7
									$users = array(
										'first_name' => $faker->firstName,
										'last_name' => $faker->lastName,
										'email' => $faker->safeEmail,
										'password' => \Hash::make('password2'),
										'key' => $faker->word,
										'code' => $faker->word,
										'phone' => $faker->numerify($string = '##########'),
										'role_id' => $faker->randomDigitNotNull,
										'sponsor_id' => $level_six->id,
										'mobile_plan_id' => $faker->randomDigitNotNull,
										'min_commission' => $faker->randomDigitNotNull,
									);
									$level_seven = Users::create($users);
									$number_level_eight = $faker->numberBetween(0,4);
									for($i_eight = 1; $i_eight <= $number_level_eight; $i_eight++) {
										//level_8
										$users = array(
											'first_name' => $faker->firstName,
											'last_name' => $faker->lastName,
											'email' => $faker->safeEmail,
											'password' => \Hash::make('password2'),
											'key' => $faker->word,
											'code' => $faker->word,
											'phone' => $faker->numerify($string = '##########'),
											'role_id' => $faker->randomDigitNotNull,
											'sponsor_id' => $level_seven->id,
											'mobile_plan_id' => $faker->randomDigitNotNull,
											'min_commission' => $faker->randomDigitNotNull,
										);
										$level_eight = Users::create($users);
										$number_level_nine = $faker->numberBetween(0,3);
										for($i_nine = 1; $i_nine <= $number_level_nine; $i_nine++) {
											//level_8
											$users = array(
												'first_name' => $faker->firstName,
												'last_name' => $faker->lastName,
												'email' => $faker->safeEmail,
												'password' => \Hash::make('password2'),
												'key' => $faker->word,
												'code' => $faker->word,
												'phone' => $faker->numerify($string = '##########'),
												'role_id' => $faker->randomDigitNotNull,
												'sponsor_id' => $level_eight->id,
												'mobile_plan_id' => $faker->randomDigitNotNull,
												'min_commission' => $faker->randomDigitNotNull,
											);
											$level_nine = Users::create($users);
											$number_level_ten = $faker->numberBetween(0,2);
											for($i_ten = 1; $i_ten <= $number_level_ten; $i_ten++) {
												//level_8
												$users = array(
													'first_name' => $faker->firstName,
													'last_name' => $faker->lastName,
													'email' => $faker->safeEmail,
													'password' => \Hash::make('password2'),
													'key' => $faker->word,
													'code' => $faker->word,
													'phone' => $faker->numerify($string = '##########'),
													'role_id' => $faker->randomDigitNotNull,
													'sponsor_id' => $level_nine->id,
													'mobile_plan_id' => $faker->randomDigitNotNull,
													'min_commission' => $faker->randomDigitNotNull,
												);
												$level_ten = Users::create($users);
											}
										}
									}
								}
							}
						}
					}
				}

			}
		}
	}

}
