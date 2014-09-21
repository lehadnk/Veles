<?php
/**
 * @file    PdoAdapterCopy.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-09-20 16:50
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\DataBase\Adapters;

use Veles\DataBase\Adapters\PdoAdapter;


/**
 * Class PdoAdapterCopy
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class PdoAdapterCopy extends PdoAdapter
{
	final public static function getCalls()
	{
		return self::$calls;
	}

	final public static function setCalls(array $calls)
	{
		self::$calls = $calls;
	}

	final public static function resetCalls()
	{
		self::$calls = null;
	}
}