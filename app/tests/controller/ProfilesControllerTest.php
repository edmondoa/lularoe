<?php 

class ProfilesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'profiles');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'profiles/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'profiles/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'profiles/1/edit');
        $this->assertResponseOk();
    }
}
