<?php 

class AddressesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'addresses');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'addresses/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'addresses/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'addresses/1/edit');
        $this->assertResponseOk();
    }
}
