<?php namespace spec\Blocks\Services;

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

    function it_checks_secret_code_with_user_input_code(Config $config)
    {
    	$secret = 'some-secret-key';
    	
    	$config->get('app.publish_secret')->shouldBecalled()->willReturn($secret);
    	$this->check($secret)->shouldReturn(true);

    	$config->get('app.publish_secret')->willReturn('wrong-secret-key');
    	$this->check($secret)->shouldReturn(false);
    }

}
