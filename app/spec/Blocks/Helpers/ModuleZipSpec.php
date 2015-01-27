<?php

namespace spec\Blocks\Helpers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Filesystem\Filesystem;

class ModuleZipSpec extends ObjectBehavior
{

	function let(Filesystem $filesystem)
	{
		$this->beConstructedWith($filesystem);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Helpers\ModuleZip');
    }

    function it_can_find_module_by_module_code(Filesystem $filesystem)
    {
    	$path = base_path('public/modules/demo-module.zip');

    	$filesystem->get($path)->shouldBeCalled()->willReturn(true);

    	$this->find('demo-module')->shouldReturn($path);
    }

}
