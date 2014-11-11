<?php 

class OpportunitiesControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'opportunity');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'opportunity/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'opportunity/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'opportunity/1/edit');
        $this->assertResponseOk();
    }
}
