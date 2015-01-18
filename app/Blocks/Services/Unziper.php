<?php namespace Blocks\Services;

use ZipArchive;

class Unziper
{
	
	public function unzip($zip)
	{
		$zip = new ZipArchive;
		$res = $zip->open($uploadedZip);

		if ($res === TRUE)
		{
		    $zip->extractTo($this->tmpModulePath);
		    $zip->close();

		    return true;
		}

		return false;
	}

}