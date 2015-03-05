<?php 

class TagsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'tag');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'tag/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'tag/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'tag/1/edit');
        $this->assertResponseOk();
    }
}
