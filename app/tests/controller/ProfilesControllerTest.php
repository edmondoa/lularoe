<?php 

class ProfilesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'profile');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'profile/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'profile/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'profile/1/edit');
        $this->assertResponseOk();
    }
}
