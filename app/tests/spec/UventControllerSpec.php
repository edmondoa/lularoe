<?php

namespace spec;

use PhpSpec\Laravel\EloquentModelBehavior;
use PhpSpec\Laravel\LaravelObjectBehavior;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UventControllerSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UventController');
    }
}