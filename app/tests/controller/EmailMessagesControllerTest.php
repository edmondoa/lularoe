<?php 

class EmailMessagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'emailMessages');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'emailMessages/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'emailMessages/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'emailMessages/1/edit');
        $this->assertResponseOk();
    }
}
