<?php 

class ImagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'images');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'images/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'images/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'images/1/edit');
        $this->assertResponseOk();
    }
}
