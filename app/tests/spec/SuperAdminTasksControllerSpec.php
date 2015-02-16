<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SuperAdminTasksControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SuperAdminTasksController');
    }
}
