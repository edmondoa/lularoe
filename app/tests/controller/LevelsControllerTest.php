<?php 

class LevelsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'levels');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'levels/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'levels/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'levels/1/edit');
        $this->assertResponseOk();
    }
}
