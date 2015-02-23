<?php

namespace spec;

use PhpSpec\Laravel\EloquentModelBehavior;
use PhpSpec\Laravel\LaravelObjectBehavior;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LeadSpec extends EloquentModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lead');
    }

    function it_should_return_type_belongsTo(){
	$this->sponsor()->shouldHaveType('Illuminate\Database\Eloquent\Relations\BelongsTo');
    }

    function it_sponsor_relation(){
	$this->sponsor()->shouldDefineRelationship('belongsTo','User');
    }

    function it_opportunity_relation(){
        $this->opportunity()->shouldDefineRelationship('belongsTo','Opportunity');
    }
    
    function it_check_fields(){
        $this::all()->shouldHaveType('Illuminate\Database\Eloquent\Collection');
        $result = $this::first()->get();
        throw new \Exception(__FUNCTION__.print_r(compact('result'),true));
    }

}
