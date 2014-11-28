<?php 

class ReviewsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'review');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'review/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'review/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'review/1/edit');
        $this->assertResponseOk();
    }
}
