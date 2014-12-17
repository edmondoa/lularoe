<?php 

class CommissionsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'commissions');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'commissions/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'commissions/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'commissions/1/edit');
        $this->assertResponseOk();
    }
}
