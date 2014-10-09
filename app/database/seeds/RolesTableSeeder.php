<?php 

class RolesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		Role::create(["name"=>"Customer"]);
		Role::create(["name"=>"Rep"]);
		Role::create(["name"=>"Editor"]);
		Role::create(["name"=>"Admin"]);
		Role::create(["name"=>"Superadmin"]);
	}

}
