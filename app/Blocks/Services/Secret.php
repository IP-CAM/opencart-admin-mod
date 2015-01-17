<?php namespace Blocks\Services;

use Illuminate\Config\Repository as Config;

class Secret
{

	protected $config;

	public function __construct(Config $config)
	{
		$this->config = $config;
	}
	
	public function check($secret)
	{
		if ($secret == $this->config->get('app.publish_secret'))
		{
			return true;
		}

		return false;
	}

}