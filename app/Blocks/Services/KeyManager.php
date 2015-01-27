<?php namespace Blocks\Services;

use Blocks\Services\KeyGenerator;
use Blocks\Repositories\KeyRepository;

class KeyManager
{

	protected $keyGenerator;
	protected $keyRepository;

    public function __construct(KeyGenerator $keyGenerator, KeyRepository $keyRepository)
    {
        $this->keyGenerator = $keyGenerator;
        $this->keyRepository = $keyRepository;
    }

    /**
     * Generate new unique key
     *
     * @return string
     */
    public function generate()
    {
        $key = $this->keyGenerator->make();
        
    	if ($this->keyRepository->exists($key))
    	{
    		return $this->generate();
    	}

    	return $key;
    }

    /**
     * Stores new key in database
     *
     * @return bool
     */
    public function create($moduleCode, $domain)
    {
        $key = $this->generate();

        return $this->keyRepository->store($key, $moduleCode, $domain);
    }

}
