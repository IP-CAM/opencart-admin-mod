<?php namespace Blocks\Billing;

class Interkassa 
{

	/**
	 * Check if the request has the right, or try to falsify
	 *
	 * @return bool
	 */
	public function validate($post_in)
	{
		$key_to_sort = $post_in;
		$ik_co_id = $key_to_sort['ik_co_id'];
		$ik_sign = $key_to_sort['ik_sign'];
		$ik_am = $key_to_sort['ik_am'];
		$ik_inv_st = $key_to_sort['ik_inv_st'];

		// Forming a digital signature
		unset($key_to_sort['ik_sign']);
		ksort($key_to_sort, SORT_STRING);

		// Add to the array "secret key"
		array_push($key_to_sort, 'hyfpD2E9J6mN65Ew');

		// Concatenate values ​​by a ":"
		$signString = implode(':', $key_to_sort);

		// Take the MD5 hash in binary form by
		$sign = base64_encode(md5($signString, true));

		// Validate kassa results
		if(
			$ik_co_id == '54d38c70bf4efcad3252c4df' AND 
			$ik_inv_st == 'success' AND 
			$ik_sign == $sign
		)
		{
			return $ik_am;
		}
		else
		{
			return false;
		}
	}

}