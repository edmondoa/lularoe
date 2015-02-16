<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserProductControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UserProductController');
    }
}
