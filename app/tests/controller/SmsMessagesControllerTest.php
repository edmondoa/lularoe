<?php 

class SmsMessagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'smsMessages');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'smsMessages/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'smsMessages/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'smsMessages/1/edit');
        $this->assertResponseOk();
    }
}
