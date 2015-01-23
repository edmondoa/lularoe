<?php 

class UserProductsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'userProduct');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'userProduct/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'userProduct/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'userProduct/1/edit');
        $this->assertResponseOk();
    }
}
