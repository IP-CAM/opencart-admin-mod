<?php

namespace spec\Blocks\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KeyGeneratorSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Services\KeyGenerator');
    }

    function it_generates_key()
    {
    	$this->make()->shouldhaveLengthOf(24);
    }
	
	public function getMatchers()
    {
        return [
            'haveLengthOf' => function($value, $max) {
                return strlen($value) == $max ? true : false;
            }
        ];
    }

}
