<?php 

class LevelsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'level');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'level/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'level/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'level/1/edit');
        $this->assertResponseOk();
    }
}
