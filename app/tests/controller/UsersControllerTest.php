<?php 

class UsersControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'user');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'user/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'user/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'user/1/edit');
        $this->assertResponseOk();
    }
}
