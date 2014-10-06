<?php 

class BonusesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'bonuses');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'bonuses/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'bonuses/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'bonuses/1/edit');
        $this->assertResponseOk();
    }
}
