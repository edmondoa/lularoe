<?php 

class CalendarsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'calendar');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'calendar/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'calendar/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'calendar/1/edit');
        $this->assertResponseOk();
    }
}
