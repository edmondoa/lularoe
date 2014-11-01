<?php 

class UserRanksControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'userRank');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'userRank/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'userRank/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'userRank/1/edit');
        $this->assertResponseOk();
    }
}
