<?php 

class SalesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'sale');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'sale/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'sale/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'sale/1/edit');
        $this->assertResponseOk();
    }
}
