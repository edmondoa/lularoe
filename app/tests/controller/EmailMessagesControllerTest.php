<?php 

class EmailMessagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'emailMessage');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'emailMessage/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'emailMessage/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'emailMessage/1/edit');
        $this->assertResponseOk();
    }
}
