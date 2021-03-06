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

		// $this->call('UsersTableSeeder');
		$this->call('StatesTableSeeder');
		$this->call('AddressesTableSeeder');
		//$this->call('LevelsTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('RanksTableSeeder');
		$this->call('ProfilesTableSeeder');
		$this->call('ProductsTableSeeder');
		$this->call('CartsTableSeeder');
		$this->call('UserProductsTableSeeder');
		$this->call('ReviewsTableSeeder');
		$this->call('BonusesTableSeeder');
		// $this->call('CommissionsTableSeeder');
		$this->call('PagesTableSeeder');
		$this->call('SalesTableSeeder');
		$this->call('EmailMessagesTableSeeder');
		$this->call('SmsMessagesTableSeeder');
		// $this->call('EmailRecipientsTableSeeder');
		// $this->call('SmsRecipientsTableSeeder');
		// $this->call('PaymentsTableSeeder');
		$this->call('RankUserTableSeeder');
		$this->call('UsersTableSeederTest');
		// $this->call('UsersTableSeederTest2');
		//$this->call('ProductCategoriesTableSeeder');
		$this->call('UventsTableSeeder');
		$this->call('UserSitesTableSeeder');
		$this->call('OpportunitiesTableSeeder');
		$this->call('LeadsTableSeeder');
	}

}
