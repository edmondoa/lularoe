<?php 

class EventsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'events');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'events/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'events/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'events/1/edit');
        $this->assertResponseOk();
    }
}
