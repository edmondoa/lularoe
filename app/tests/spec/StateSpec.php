<?php

namespace spec;

use PhpSpec\Laravel\EloquentModelBehavior;
use PhpSpec\Laravel\LaravelObjectBehavior;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSpec extends EloquentModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('State');
    }
}
