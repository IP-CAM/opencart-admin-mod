<?php

namespace spec\Blocks\Helpers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Filesystem\Filesystem;
use Blocks\Helpers\ModuleZip;

class ModuleJsonSpec extends ObjectBehavior
{

	function let(Filesystem $filesystem, ModuleZip $moduleZip)
	{
		$this->beConstructedWith($filesystem, $moduleZip);
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
    		'code' => 'demo-name',
    		'version' => 'demo-version',
    		'title' => 'demo-title',
    		'description' => 'demo-description',
		]);

    	$filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        $filesystem->deleteDirectory(base_path("public/modules/{$module}"))->shouldBeCalled();

    	$this->describe($module)->shouldBeAnInstanceOf('Blocks\Helpers\ModuleJson');
    }

    function it_can_grab_uploaded_module_params(Filesystem $filesystem)
    {
        $module = 'uploaded-module';
    	$modulePath = 'tmp/uploaded-module/module.json';
    	$json = json_encode([
    		'code' => 'demo-name',
    		'version' => 'demo-version',
    		'title' => 'demo-title',
    		'description' => 'demo-description',
		]);

    	$filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        $filesystem->deleteDirectory(base_path("public/modules/{$module}"))->shouldBeCalled();

    	$moduleInfo = $this->describe($module);
    	$moduleInfo->getCode()->shouldBe('demo-name');
    	$moduleInfo->getVersion()->shouldBe('demo-version');
    	$moduleInfo->getTitle()->shouldBe('demo-title');
    	$moduleInfo->getDescription()->shouldBe('demo-description');
    }

    function it_can_read_regular_module_json_file(Filesystem $filesystem, ModuleZip $moduleZip)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'code' => 'demo-name',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        $filesystem->deleteDirectory(base_path("public/modules/{$module}"))->shouldBeCalled();
        $moduleZip->unzip(
            base_path("public/modules/{$module}.zip"), 
            base_path("public/modules/{$module}")
        )->shouldBeCalled();

        $this->describe($module)->shouldBeAnInstanceOf('Blocks\Helpers\ModuleJson');
    }

    function it_can_grab_regular_module_params(Filesystem $filesystem)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'code' => 'demo-name',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        $filesystem->deleteDirectory(base_path("public/modules/{$module}"))->shouldBeCalled();

        $moduleInfo = $this->describe($module);
        $moduleInfo->getCode()->shouldBe('demo-name');
        $moduleInfo->getVersion()->shouldBe('demo-version');
        $moduleInfo->getTitle()->shouldBe('demo-title');
        $moduleInfo->getDescription()->shouldBe('demo-description');
    }

    function it_updates_module_param_by_its_param_code(Filesystem $filesystem)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'code' => 'demo-name',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        $filesystem->deleteDirectory(base_path("public/modules/{$module}"))->shouldBeCalled();
        
        $moduleInfo = $this->describe($module);
        $moduleInfo->override('version', '1.0.0');
        
        $moduleInfo->shouldThrow('InvalidArgumentException')->during('override', ['', '']);
    }

    function it_throws_exception_if_module_has_empty_code(Filesystem $filesystem)
    {
        $module = 'demo-module';
        $modulePath = 'public/modules/demo-module/module.json';
        $json = json_encode([
            'code' => '',
            'version' => 'demo-version',
            'title' => 'demo-title',
            'description' => 'demo-description',
        ]);

        $filesystem->get($modulePath)->shouldBeCalled()->willReturn($json);
        $filesystem->deleteDirectory(base_path("public/modules/{$module}"))->shouldBeCalled();
        
        $moduleInfo = $this->describe($module);
        $moduleInfo->shouldThrow('Blocks\Helpers\Exceptions\InvatidCodeException')->during('getCode');
    }

}
