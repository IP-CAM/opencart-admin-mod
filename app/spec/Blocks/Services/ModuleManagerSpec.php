<?php

namespace spec\Blocks\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Blocks\Helpers\ModuleZip;
use Blocks\Helpers\ModuleJson;
use Blocks\Repositories\ModuleRepository;

class ModuleManagerSpec extends ObjectBehavior
{

	function let(ModuleZip $moduleZip, ModuleJson $moduleJson, ModuleRepository $moduleRepository)
	{
		$this->beConstructedWith($moduleZip, $moduleJson, $moduleRepository);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Services\ModuleManager');
    }

    function it_copies_uploaded_module_to_modules_list(ModuleZip $moduleZip, ModuleJson $moduleJson, ModuleRepository $moduleRepository)
    {
    	$zip = 'path/to/uploaded-module.zip';
    	$json = json_encode([
    		'name' => 'demo-name',
    		'version' => 'demo-version',
    		'title' => 'demo-title',
    		'description' => 'demo-description',
		]);

        $moduleZip->unzip($zip)->shouldBeCalled();
    	$moduleZip->copy($zip, 'demo-module')->shouldBeCalled();

        $moduleJson->describe('uploaded-module')->shouldBeCalled()->willReturn($moduleJson);
        $moduleJson->getName()->shouldBeCalled()->willReturn('demo-module');

        $moduleRepository->save($moduleJson)->shouldBeCalled();

    	$this->store($zip)->shouldBe(true);
    }

}
