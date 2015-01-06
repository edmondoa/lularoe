<?php 

class SmsMessagesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'smsMessage');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'smsMessage/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'smsMessage/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'smsMessage/1/edit');
        $this->assertResponseOk();
    }
}
