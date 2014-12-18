<?php 

class AttachmentsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'attachment');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'attachment/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'attachment/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'attachment/1/edit');
        $this->assertResponseOk();
    }
}
