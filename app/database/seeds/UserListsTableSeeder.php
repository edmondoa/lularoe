<?php 
class UserListsTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        Eloquent::unguard();
        $faker = $this->getFaker();
        
        for($i = 1; $i <= 500000; $i++) {
            $users = array(
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->safeEmail,
                'password' => \Hash::make('password2'),
                'key' => $faker->word,
                'phone' => $faker->numerify($string = '##########'),
                'dob' => $faker->date,
                'phone' => $faker->randomDigitNotNull,
                'role_id' => $faker->numberBetween($min = 1, $max = 4),
                'sponsor_id' => $faker->numberBetween($min = 2001, $max = 2017),
                'mobile_plan_id' => $faker->randomDigitNotNull,
                'min_commission' => $faker->randomDigitNotNull,
                'disabled' => $faker->boolean,
            );
            UserList::create($users);
        }    
    }
}
?>
