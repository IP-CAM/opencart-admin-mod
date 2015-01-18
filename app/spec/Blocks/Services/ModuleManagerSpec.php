<?php

namespace spec\Blocks\Services;

use Blocks\Services\Unziper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ZipArchive;
use Illuminate\Filesystem\Filesystem;

class ModuleManagerSpec extends ObjectBehavior
{

	function let(Unziper $unziper, Filesystem $filesystem)
	{
		$basePath = __DIR__ . '/../../../../';

		$this->beConstructedWith($basePath, $unziper, $filesystem);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\Services\ModuleManager');
    }

    function it_unzip_uploaded_module_to_tmp_folder(Unziper $unziper)
    {
    	$basePath = __DIR__ . '/../../../../';
    	$moduleTempPath = $basePath . '/tmp/uploaded-module';

    	// File exists
    	$zip = $basePath . 'app/spec/demo-content/demo2.zip';
    	$unziper->unzip($zip, $moduleTempPath)->willReturn(true);
    	$this->handle($zip)->shouldBe(true);

    	// File doesn't exists
    	$zip = $basePath . 'app/spec/demo-content/non-existing.zip';
    	$unziper->unzip($zip, $moduleTempPath)->willReturn(false);
    	$this->handle($zip)->shouldBe(false);
    }

    function it_can_read_uploaded_module_json_file(Filesystem $filesystem)
    {
    	$basePath = __DIR__ . '/../../../../';
    	$moduleTempPath = $basePath . '/tmp/uploaded-module';
    	$moduleInfo = ['name' => 'Demo module'];

    	$filesystem
    		->get($moduleTempPath . '/module.json')
    		->shouldBeCalled()
    		->willReturn(json_encode($moduleInfo));

    	$this->describeUploaded()->shouldBeObject();
    }

    function it_copies_module_to_module_list_folder(Filesystem $filesystem)
    {
    	$basePath = __DIR__ . '/../../../../';
    	$moduleListPath = $basePath . '/public/modules';
    	$zip = $basePath . 'app/spec/demo-content/demo2.zip';

    	$filesystem
    		->delete($moduleListPath . '/demo-module.zip')
    		->shouldBeCalled();

		$filesystem
    		->copy($zip, "{$moduleListPath}/demo-module.zip")
    		->shouldBeCalled()
    		->willReturn(true);

    	$this->copy($zip, 'demo-module')->shouldBe(true);
    }

}
