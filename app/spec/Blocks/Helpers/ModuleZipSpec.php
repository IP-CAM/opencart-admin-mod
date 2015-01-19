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

}
