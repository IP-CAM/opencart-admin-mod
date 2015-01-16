<?php namespace Blocks\Services;

use Illuminate\Support\Facades\Config;

class Secret
{
	
	public function check($secret)
	{
		if ($secret === Config::get('app.publish_secret'))
		{
			return true;
		}

		return false;
	}

}