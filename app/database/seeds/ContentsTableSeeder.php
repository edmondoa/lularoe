<?php 

class ContentsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$content = array(
				'page_id' => $faker->randomDigitNotNull,
				'section' => $faker->word,
				'content' => $faker->text,
			);
			Content::create($content);
		}
	}

}
