<?php namespace Blocks\Services;

class KeyGenerator
{

	public $keyChunks = 4;
	public $keyParts = 5;
	public $keyPrefix = "";
	public $keyPostfix = "";
	public $keySplit = TRUE;
	public $keyDivision = "-";
	
	private $num_range_low = 48;
	private $num_range_high = 57;
	private $chr_range_low = 65;
	private $chr_range_high = 90;

    public function make()
    {
        return $this->generate();
    }

    protected function generate()
    {
		$key = "";
		
		// Loop through each key part
		for($i = 0; $i != $this->keyParts; $i++)
		{
			// Add random character to current part
			for($x = 0; $x != $this->keyChunks; $x++)
			{
				// Generate a random character or number and append it to the string
				$key .= (
					mt_rand() & 1 == 1 
						? chr(mt_rand($this->num_range_low,$this->num_range_high))
						: chr(mt_rand($this->chr_range_low,$this->chr_range_high))
				);
			}
			
			// If keySplit is true, add the keyDivision, else, add nothing
			$key .= $this->keySplit ? $this->keyDivision : "";	
		}
		
		// Trim any extra dividers
		return trim($this->keyPrefix . $this->keyDivision . $key . $this->keyPostfix, $this->keyDivision);
    }
    
}
