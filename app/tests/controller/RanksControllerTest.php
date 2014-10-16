<?php 

class RanksControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'rank');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'rank/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'rank/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'rank/1/edit');
        $this->assertResponseOk();
    }
}
