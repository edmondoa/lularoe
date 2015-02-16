<?php

namespace spec;

use PhpSpec\Laravel\EloquentModelBehavior;
use PhpSpec\Laravel\LaravelObjectBehavior;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LeadControllerSpec extends LaravelObjectBehavior
{        
    function it_is_initializable()
    {
        $this->shouldHaveType('LeadController');
    }
    
    function it_check_primary_key(\Lead $lead){
        $lead = new \Lead();
        
        if($lead->getKeyName() != 'id'){
            throw new \ErrorException('Primary Key is not ID');   
        }
    }
    
    function it_check_fields(\Lead $lead){
        $result = \Lead::first()->get();
        #throw new \Exception(__FUNCTION__.print_r (compact('result'),true));
        //$this->collections()->shouldReturn([]);
    }
}
