<?php

namespace spec\Blocks\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Config\Repository as Config;

class SecretSpec extends ObjectBehavior
{

	function let(Config $config)
	{
		$this->beConstructedWith($config);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Services\Secret');
    }

    function it_should_check_input_key_with_secret_key(Config $config)
    {
        // Correct key
    	$config->get('app.publish_secret')->shouldBeCalled()->willReturn('testing-secret');
        $this->check('testing-secret')->shouldBe(true);
        
        // Wrong key
        $config->get('app.publish_secret')->shouldBeCalled()->willReturn('wrong-secret-key');
        $this->check('testing-secret')->shouldBe(false);
    }

}
