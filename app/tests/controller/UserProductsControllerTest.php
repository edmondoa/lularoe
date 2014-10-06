<?php 

class UserProductsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'userProducts');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'userProducts/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'userProducts/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'userProducts/1/edit');
        $this->assertResponseOk();
    }
}
