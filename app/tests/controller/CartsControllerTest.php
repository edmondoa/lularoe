<?php 

class CartsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'cart');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'cart/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'cart/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'cart/1/edit');
        $this->assertResponseOk();
    }
}
