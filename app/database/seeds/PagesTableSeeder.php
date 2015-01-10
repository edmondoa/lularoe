<?php 

class PagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 20; $i++) {
			$page = array(
				'title' => $faker->word,
				'url' => $faker->url,
				'type' => $faker->word,
				'body' => $faker->text,
				'disabled' => $faker->boolean,
			);
			Page::create($page);
		}
	}

}
