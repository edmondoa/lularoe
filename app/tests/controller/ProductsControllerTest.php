<?php 

class ProductsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'products');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'products/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'products/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'products/1/edit');
        $this->assertResponseOk();
    }
}
