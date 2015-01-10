<?php 

class ContentsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'content');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'content/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'content/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'content/1/edit');
        $this->assertResponseOk();
    }
}
