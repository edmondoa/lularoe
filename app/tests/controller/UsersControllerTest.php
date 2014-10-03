<?php 

class UsersControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'users');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'users/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'users/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'users/1/edit');
        $this->assertResponseOk();
    }
}
