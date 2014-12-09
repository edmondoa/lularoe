<?php 

class ProductsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'product');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'product/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'product/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'product/1/edit');
        $this->assertResponseOk();
    }
}
