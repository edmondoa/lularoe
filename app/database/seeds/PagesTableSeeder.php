<?php 

class PagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$pages = array(
				'name' => $faker->name,
				'url' => $faker->url,
				'type' => $faker->word,
				'opportunity' => $faker->boolean,
			);
			Pages::create($pages);
		}
	}

}
