<?php 

class SmsRecipientsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'smsRecipients');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'smsRecipients/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'smsRecipients/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'smsRecipients/1/edit');
        $this->assertResponseOk();
    }
}
