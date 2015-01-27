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
    		'code' => 'demo-name',
    		'version' => 'demo-version',
    		'title' => 'demo-title',
    		'description' => 'demo-description',
		]);

        $moduleZip->unzip($zip)->shouldBeCalled();
    	$moduleZip->copy($zip, 'demo-module')->shouldBeCalled();

        $moduleJson->describe('uploaded-module')->shouldBeCalled()->willReturn($moduleJson);
        $moduleJson->getCode()->shouldBeCalled()->willReturn('demo-module');
        $moduleJson->getVersion()->shouldBeCalled()->willReturn('demo-version');

        $moduleRepository->save([
            'code' => 'demo-module',
            'version' => 'demo-version'
        ])->shouldBeCalled();

    	$this->store($zip)->shouldBe(true);
    }

    function it_checks_if_module_zip_exists_by_module_code(ModuleZip $moduleZip)
    {
        $moduleCode = 'demo-module';
        $modulePath = base_path('public/modules/demo-module.zip');

        $moduleZip->find($moduleCode)->shouldBeCalled()->willReturn($modulePath);

        $this->find($moduleCode)->shouldReturn($modulePath);
    }

}
