<?php

namespace Achse\GethJsonRpcPhpClient;

use Nette\Object;



class Utils extends Object
{

	/**
	 * @see http://stackoverflow.com/questions/1273484/large-hex-values-with-php-hexdec
	 *
	 * @param string $hex
	 * @return string
	 */
	public static function bigHexToBigDec($hex)
	{
		$dec = '0';
		$len = strlen($hex);
		for ($i = 1; $i <= $len; $i++) {
			$dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
		}

		return $dec;
	}
	/**
	 * @see http://stackoverflow.com/questions/45527318/convert-wei-to-ethereum-with-php
	 *
	 * @param string $wei
	 * @return string
	 */
	public static function wei2eth($wei)
	{
		return bcdiv($wei,'1000000000000000000',18);
	}
	/**
	 * @param string $eth
	 * @return string
	 */
	public static function eth2wei($eth)
	{
		return bcmul($eth,'1000000000000000000');
	}

}
