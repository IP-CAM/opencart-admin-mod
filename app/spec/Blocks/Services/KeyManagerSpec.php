<?php

namespace spec\Blocks\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Blocks\Services\KeyGenerator;
use Blocks\Repositories\KeyRepository;

class KeyManagerSpec extends ObjectBehavior
{

	function let(KeyGenerator $keyGenerator, KeyRepository $keyRepository)
	{
		$this->beConstructedWith($keyGenerator, $keyRepository);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Services\KeyManager');
    }

    function it_creates_unique_key_and_stores_it_in_database(KeyGenerator $keyGenerator, KeyRepository $keyRepository)
    {
    	$key = "4PBB-8481-B869-U85P-M306";

    	$keyGenerator->make()->shouldBeCalled()->willReturn($key);
    	$keyRepository->exists($key)->shouldBeCalled()->willReturn(false);

    	$this->generate()->shouldBe($key);
    }

    function it_saves_key_in_database(KeyGenerator $keyGenerator, KeyRepository $keyRepository)
    {
        $key = "4PBB-8481-B869-U85P-M306";
        $moduleId = 1;
        $domain = 'example.com';

        $keyGenerator->make()->shouldBeCalled()->willReturn($key);
        $keyRepository->exists($key)->shouldBeCalled()->willReturn(false);
        $keyRepository->store($key, $moduleId, $domain)->shouldBeCalled()->willReturn(true);

        $this->create($moduleId, $domain)->shouldBe(true);
    }

}
