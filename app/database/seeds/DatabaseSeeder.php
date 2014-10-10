<?php

class DatabaseSeeder extends Seeder {
	protected $faker;

	public function getFaker()
	{
		if(empty($this->faker)) {
			$this->faker = Faker\Factory::create();
		}

		return $this->faker;
	}



	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('StatesTableSeeder');
		$this->call('AddressesTableSeeder');
		//$this->call('LevelsTableSeeder');
		$this->call('RolesTableSeeder');
		//$this->call('RanksTableSeeder');
		//$this->call('UserRanksTableSeeder');
		//$this->call('ProfilesTableSeeder');
		$this->call('ProductsTableSeeder');
		//$this->call('CartsTableSeeder');
		//$this->call('UserProductsTableSeeder');
		//$this->call('ReviewsTableSeeder');
		//$this->call('MobilePlansTableSeeder');
		//$this->call('BonusesTableSeeder');
		//$this->call('CommissionsTableSeeder');
		//$this->call('PagesTableSeeder');
		//$this->call('ContentsTableSeeder');
		//$this->call('ImagesTableSeeder');
		//$this->call('SalesTableSeeder');
		//$this->call('EmailMessagesTableSeeder');
		//$this->call('SmsMessagesTableSeeder');
		//$this->call('EmailRecipientsTableSeeder');
		//$this->call('SmsRecipientsTableSeeder');
		//$this->call('PaymentsTableSeeder');
		//$this->call('UsersTableSeederTest');

		$this->call('ProductCategoriesTableSeeder');
	}

}
