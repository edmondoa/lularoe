<?php 

class RanksControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'ranks');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'ranks/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'ranks/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'ranks/1/edit');
        $this->assertResponseOk();
    }
}
