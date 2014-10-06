<?php 

class UserRanksControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'userRanks');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'userRanks/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'userRanks/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'userRanks/1/edit');
        $this->assertResponseOk();
    }
}
