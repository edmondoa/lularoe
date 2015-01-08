<?php 

class UserSitesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'userSite');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'userSite/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'userSite/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'userSite/1/edit');
        $this->assertResponseOk();
    }
}
