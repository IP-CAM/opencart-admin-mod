<?php

namespace spec\Blocks\Helpers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Filesystem\Filesystem;

class ModuleJsonSpec extends ObjectBehavior
{

	function let(Filesystem $filesystem)
	{
		$this->beConstructedWith($filesystem);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Helpers\ModuleJson');
    }

    function it_can_read_uploaded_module_json_file(Filesystem $filesystem)
    {
        $module = 'uploaded-module';
    	$modulePath = 'tmp/uploaded-module/module.json';
    	$json = json_encode([
    		'name' => 'demo-name',
    		'version' => 'demo-version',
    		'title' => 'demo-title',
    		'description' => 'demo-description',
		]);

    	$filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);

    	$this->describe($module)->shouldBeAnInstanceOf('Blocks\Helpers\ModuleJson');
    }

    function it_can_grab_uploaded_module_params(Filesystem $filesystem)
    {
        $module = 'uploaded-module';
    	$modulePath = 'tmp/uploaded-module/module.json';
    	$json = json_encode([
    		'name' => 'demo-name',
    		'version' => 'demo-version',
    		'title' => 'demo-title',
    		'description' => 'demo-description',
		]);

    	$filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);

    	$moduleInfo = $this->describe($module);
    	$moduleInfo->getName()->shouldBe('demo-name');
    	$moduleInfo->getVersion()->shouldBe('demo-version');
    	$moduleInfo->getTitle()->shouldBe('demo-title');
    	$moduleInfo->getDescription()->shouldBe('demo-description');
    }

    function it_can_read_regular_module_json_file(Filesystem $filesystem)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'name' => 'demo-name',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);

        $this->describe($module)->shouldBeAnInstanceOf('Blocks\Helpers\ModuleJson');
    }

    function it_can_grab_regular_module_params(Filesystem $filesystem)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'name' => 'demo-name',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);

        $moduleInfo = $this->describe($module);
        $moduleInfo->getName()->shouldBe('demo-name');
        $moduleInfo->getVersion()->shouldBe('demo-version');
        $moduleInfo->getTitle()->shouldBe('demo-title');
        $moduleInfo->getDescription()->shouldBe('demo-description');
    }

    function it_updates_module_param_by_its_param_code(Filesystem $filesystem)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'name' => 'demo-name',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        
        $moduleInfo = $this->describe($module);
        $moduleInfo->override('version', '1.0.0');
        
        $moduleInfo->shouldThrow('InvalidArgumentException')->during('override', ['', '']);
    }

}
