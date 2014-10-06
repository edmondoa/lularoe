<?php 

class ReviewsControllerTest extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'reviews');
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->call('GET', 'reviews/1');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $this->call('GET', 'reviews/create');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->call('GET', 'reviews/1/edit');
        $this->assertResponseOk();
    }
}
