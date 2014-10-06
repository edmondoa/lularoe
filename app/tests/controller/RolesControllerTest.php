<?php 

class RolesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'roles');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'roles/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'roles/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'roles/1/edit');
        $this->assertResponseOk();
    }
}
