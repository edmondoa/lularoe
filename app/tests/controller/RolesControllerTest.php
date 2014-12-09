<?php 

class RolesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'role');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'role/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'role/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'role/1/edit');
        $this->assertResponseOk();
    }
}
