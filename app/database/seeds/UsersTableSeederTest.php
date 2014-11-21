<?php 

class UsersTableSeederTest extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		$now = date('Y-m-d H:i:s');
		$number_founders = $faker->numberBetween(3,5);
		for($i = 1; $i <= $number_founders; $i++) {
			//$founder_id = $i;
			//Level_1
			$users = array(
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'email' => $faker->safeEmail,
				'password' => \Hash::make('password2'),
				'key' => $faker->word,
				'phone' => $faker->numerify($string = '##########'),
				'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
				'gender' => $faker->randomElement(['F','M']),
				'role_id' => 2,
				'public_id' => $faker->lexify('???????????????????????????'),
				'sponsor_id' => 0,
				'mobile_plan_id' => $faker->randomDigitNotNull,
				'min_commission' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
				'created_at' => $now,
				'updated_at' => $now,
			);
			$founder = User::create($users);
			$number_level_two = $faker->numberBetween(1,5);
			for($i_two = 1; $i_two <= $number_level_two; $i_two++) {
				//level_2
				$users = array(
					'first_name' => $faker->firstName,
					'last_name' => $faker->lastName,
					'email' => $faker->safeEmail,
					'password' => \Hash::make('password2'),
					'key' => $faker->word,
					'phone' => $faker->numerify($string = '##########'),
					'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
					'gender' => $faker->randomElement(['F','M']),
					'role_id' => 2,
					'public_id' => $faker->lexify('???????????????????????????'),
					'sponsor_id' => $founder->id,
					'mobile_plan_id' => $faker->randomDigitNotNull,
					'min_commission' => $faker->randomDigitNotNull,
					'disabled' => $faker->boolean,
					'created_at' => $now,
					'updated_at' => $now,
				);
				$level_two = User::create($users);
				$number_level_three = $faker->numberBetween(0,5);
				for($i_three = 1; $i_three <= $number_level_three; $i_three++) {
					//level_3
					$users = array(
						'first_name' => $faker->firstName,
						'last_name' => $faker->lastName,
						'email' => $faker->safeEmail,
						'password' => \Hash::make('password2'),
						'key' => $faker->word,
						'phone' => $faker->numerify($string = '##########'),
						'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
						'gender' => $faker->randomElement(['F','M']),
						'role_id' => 2,
						'public_id' => $faker->lexify('???????????????????????????'),
						'sponsor_id' => $level_two->id,
						'mobile_plan_id' => $faker->randomDigitNotNull,
						'min_commission' => $faker->randomDigitNotNull,
						'disabled' => $faker->boolean,
						'created_at' => $now,
						'updated_at' => $now,
					);
					$level_three = User::create($users);
					$number_level_four = $faker->numberBetween(0,5);
					for($i_four = 1; $i_four <= $number_level_four; $i_four++) {
						//level_4
						$users = array(
							'first_name' => $faker->firstName,
							'last_name' => $faker->lastName,
							'email' => $faker->safeEmail,
							'password' => \Hash::make('password2'),
							'key' => $faker->word,
							'phone' => $faker->numerify($string = '##########'),
							'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
							'gender' => $faker->randomElement(['F','M']),
							'role_id' => 2,
							'public_id' => $faker->lexify('???????????????????????????'),
							'sponsor_id' => $level_three->id,
							'mobile_plan_id' => $faker->randomDigitNotNull,
							'min_commission' => $faker->randomDigitNotNull,
							'disabled' => $faker->boolean,
							'created_at' => $now,
							'updated_at' => $now,
						);
						$level_four = User::create($users);
						$number_level_five = $faker->numberBetween(0,4);
						for($i_five = 1; $i_five <= $number_level_five; $i_five++) {
							//level_5
							//continue;
							$users = array(
								'first_name' => $faker->firstName,
								'last_name' => $faker->lastName,
								'email' => $faker->safeEmail,
								'password' => \Hash::make('password2'),
								'key' => $faker->word,
								'phone' => $faker->numerify($string = '##########'),
								'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
								'gender' => $faker->randomElement(['F','M']),
								'role_id' => 2,
								'public_id' => $faker->lexify('???????????????????????????'),
								'sponsor_id' => $level_four->id,
								'mobile_plan_id' => $faker->randomDigitNotNull,
								'min_commission' => $faker->randomDigitNotNull,
								'disabled' => $faker->boolean,
								'created_at' => $now,
								'updated_at' => $now,
							);
							$level_five = User::create($users);
							$number_level_six = $faker->numberBetween(0,4);
							for($i_six = 1; $i_six <= $number_level_six; $i_six++) {
								//level_6
								$users = array(
									'first_name' => $faker->firstName,
									'last_name' => $faker->lastName,
									'email' => $faker->safeEmail,
									'password' => \Hash::make('password2'),
									'key' => $faker->word,
									'phone' => $faker->numerify($string = '##########'),
									'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
									'gender' => $faker->randomElement(['F','M']),
									'role_id' => 2,
									'public_id' => $faker->lexify('???????????????????????????'),
									'sponsor_id' => $level_five->id,
									'mobile_plan_id' => $faker->randomDigitNotNull,
									'min_commission' => $faker->randomDigitNotNull,
									'disabled' => $faker->boolean,
									'created_at' => $now,
									'updated_at' => $now,
								);
								$level_six = User::create($users);
								$number_level_seven = $faker->numberBetween(0,3);
								for($i_seven = 1; $i_seven <= $number_level_seven; $i_seven++) {
									//level_7
									$users = array(
										'first_name' => $faker->firstName,
										'last_name' => $faker->lastName,
										'email' => $faker->safeEmail,
										'password' => \Hash::make('password2'),
										'key' => $faker->word,
										'phone' => $faker->numerify($string = '##########'),
										'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
										'gender' => $faker->randomElement(['F','M']),
										'role_id' => 2,
										'public_id' => $faker->lexify('???????????????????????????'),
										'sponsor_id' => $level_six->id,
										'mobile_plan_id' => $faker->randomDigitNotNull,
										'min_commission' => $faker->randomDigitNotNull,
										'disabled' => $faker->boolean,
										'created_at' => $now,
										'updated_at' => $now,
									);
									$level_seven = User::create($users);
									$number_level_eight = $faker->numberBetween(0,2);
									for($i_eight = 1; $i_eight <= $number_level_eight; $i_eight++) {
										//level_8
										$users = array(
											'first_name' => $faker->firstName,
											'last_name' => $faker->lastName,
											'email' => $faker->safeEmail,
											'password' => \Hash::make('password2'),
											'key' => $faker->word,
											'phone' => $faker->numerify($string = '##########'),
											'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
											'gender' => $faker->randomElement(['F','M']),
											'role_id' => 2,
											'public_id' => $faker->lexify('???????????????????????????'),
											'sponsor_id' => $level_seven->id,
											'mobile_plan_id' => $faker->randomDigitNotNull,
											'min_commission' => $faker->randomDigitNotNull,
											'disabled' => $faker->boolean,
											'created_at' => $now,
											'updated_at' => $now,
										);
										$level_eight = User::create($users);
										$number_level_nine = $faker->numberBetween(0,2);
										for($i_nine = 1; $i_nine <= $number_level_nine; $i_nine++) {
											//level_8
											$users = array(
												'first_name' => $faker->firstName,
												'last_name' => $faker->lastName,
												'email' => $faker->safeEmail,
												'password' => \Hash::make('password2'),
												'key' => $faker->word,
												'phone' => $faker->numerify($string = '##########'),
												'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
												'gender' => $faker->randomElement(['F','M']),
												'role_id' => 2,
												'public_id' => $faker->lexify('???????????????????????????'),
												'sponsor_id' => $level_eight->id,
												'mobile_plan_id' => $faker->randomDigitNotNull,
												'min_commission' => $faker->randomDigitNotNull,
												'disabled' => $faker->boolean,
												'created_at' => $now,
												'updated_at' => $now,
											);
											$level_nine = User::create($users);
											$number_level_ten = $faker->numberBetween(0,2);
											for($i_ten = 1; $i_ten <= $number_level_ten; $i_ten++) {
												//level_8
												$users = array(
													'first_name' => $faker->firstName,
													'last_name' => $faker->lastName,
													'email' => $faker->safeEmail,
													'password' => \Hash::make('password2'),
													'key' => $faker->word,
													'phone' => $faker->numerify($string = '##########'),
													'dob' => $faker->date($format = 'Y-m-d', '-18 years'),
													'gender' => $faker->randomElement(['F','M']),
													'role_id' => 2,
													'public_id' => $faker->lexify('???????????????????????????'),
													'sponsor_id' => $level_nine->id,
													'mobile_plan_id' => $faker->randomDigitNotNull,
													'min_commission' => $faker->randomDigitNotNull,
													'disabled' => $faker->boolean,
													'created_at' => $now,
													'updated_at' => $now,
												);
												$level_ten = User::create($users);
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
		User::create([
			'id' => 10000,
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'customer@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 1,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'id' => 10004,
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'rep@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 2,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => 'local_one'
		]);
		User::create([
			'id' => 10005,
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'editor@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 3,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'id' => 10006,
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'admin@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 4,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'id' => 10007,
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'superadmin@example.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 5,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'id' => 10008,
			'first_name' => 'Steve',
			'last_name' => 'Gashler',
			'email' => 'sgashler@controlpad.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 5,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
		User::create([
			'id' => 10009,
			'first_name' => 'Jake',
			'last_name' => 'Barlow',
			'email' => 'jbarlow@controlpad.com',
			'password' => \Hash::make('password2'),
			'key' => $faker->word,
			'phone' => $faker->numerify($string = '##########'),
			'dob' => $faker->date,
			'role_id' => 5,
			'sponsor_id' => 0,
			'mobile_plan_id' => $faker->randomDigitNotNull,
			'min_commission' => $faker->randomDigitNotNull,
			'disabled' => $faker->boolean,
			'public_id' => $faker->word
		]);
	}

}
