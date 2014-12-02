<?php 

class BonusesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'bonus');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'bonus/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'bonus/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'bonus/1/edit');
        $this->assertResponseOk();
    }
}
