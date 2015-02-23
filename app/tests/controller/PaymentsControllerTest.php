<?php 

class PaymentsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'payments');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'payments/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'payments/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'payments/1/edit');
        $this->assertResponseOk();
    }
}
