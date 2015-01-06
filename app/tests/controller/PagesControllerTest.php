<?php 

class PagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'page');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'page/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'page/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'page/1/edit');
        $this->assertResponseOk();
    }
}
