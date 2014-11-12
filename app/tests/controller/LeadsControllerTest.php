<?php 

class LeadsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'lead');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'lead/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'lead/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'lead/1/edit');
        $this->assertResponseOk();
    }
}
