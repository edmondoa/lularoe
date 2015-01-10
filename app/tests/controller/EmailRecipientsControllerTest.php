<?php 

class EmailRecipientsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'emailRecipients');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'emailRecipients/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'emailRecipients/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'emailRecipients/1/edit');
        $this->assertResponseOk();
    }
}
