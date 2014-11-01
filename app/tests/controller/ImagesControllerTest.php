<?php 

class ImagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'image');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'image/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'image/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'image/1/edit');
        $this->assertResponseOk();
    }
}
