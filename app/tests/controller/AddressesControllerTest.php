<?php 

class AddressesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'address');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'address/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'address/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'address/1/edit');
        $this->assertResponseOk();
    }
}
