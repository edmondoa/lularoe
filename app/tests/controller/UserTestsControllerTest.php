<?php 

class UserTestsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'userTest');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'userTest/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'userTest/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'userTest/1/edit');
        $this->assertResponseOk();
    }
}
