<?php 

class ProductCategoriesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'productCategory');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'productCategory/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'productCategory/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'productCategory/1/edit');
        $this->assertResponseOk();
    }
}
