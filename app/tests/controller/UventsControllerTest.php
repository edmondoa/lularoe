<?php 

class UventsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'uvent');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'uvent/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'uvent/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'uvent/1/edit');
        $this->assertResponseOk();
    }
}
