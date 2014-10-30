<?php
/**
 * Unit-test for AutoLoader class
 * @file    AutoLoaderTest.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Янв 20 22:07:49 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionObject;
use Veles\AutoLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 21:31:21.
 */
class AutoLoaderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for AutoLoader::init
	 * @group RootClasses
	 * @covers Veles\AutoLoader::init
	 * @see    Veles\AutoLoader::init
	 */
	public function testInit()
	{
		$expected = <<<EOF
	public static function init()
	{
		spl_autoload_register(__NAMESPACE__ . '\AutoLoader::load');
	}

EOF;
		$object = new ReflectionObject(new AutoLoader);
		$method = $object->getMethod('init');
		$path   = $method->getFileName();
		$lines  = file($path);
		$start  = $method->getStartLine() - 1;
		$end    = $method->getEndLine();
		$len    = $end - $start;

		$result = implode(array_slice($lines, $start, $len));

		$msg = 'Wrong content of AutoLoader::init() method';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * Unit-test for AutoLoader::load
	 * @group RootClasses
	 * @covers Veles\AutoLoader::load
	 * @see    AutoLoader::load()
	 */
	public function testLoad()
	{
		AutoLoader::load('Veles\Tests\AutoLoaderFake');

		$result = array_search('Veles\Tests\AutoLoaderFake', get_declared_classes());

		$msg = 'Class AutoLoaderFake did not loaded';
		self::assertTrue(false !== $result, $msg);
	}
}
