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
        if ($this->config->get('app.publish_secret') == $secret)
        {
        	return true;
        }

        return false;
    }

}
