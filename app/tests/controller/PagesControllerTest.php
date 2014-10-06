<?php 

class PagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'pages');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'pages/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'pages/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'pages/1/edit');
        $this->assertResponseOk();
    }
}
