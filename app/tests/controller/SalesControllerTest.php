<?php 

class SalesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'sales');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'sales/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'sales/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'sales/1/edit');
        $this->assertResponseOk();
    }
}
