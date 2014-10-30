<?php
/**
 * Unit-test for Byte class
 * @file    ByteTest.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-05-24 07:54
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Validators;

use PHPUnit_Framework_TestCase;
use Veles\Validators\Byte;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-05-24 at 07:54:20.
 */
class ByteTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Byte
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Byte;
	}

	/**
	 * @covers Veles\Validators\Byte::check
	 * @group  Validators
	 * @see	   Byte::check()
	 * @dataProvider checkProvider
	 */
	public function testCheck($size, $expected)
	{
		$result = $this->object->check($size);

		$msg = 'Wrong Byte::check() validation';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * Data-provider for testCheck
	 */
	public function checkProvider()
	{
		return array(
			array(123, true),
			array(500, true),
			array(-1298, true),
			array(23.34, true),
			array('one', false),
			array('23', true)
		);
	}

	/**
	 * @covers Veles\Validators\Byte::format
	 * @group  Validators
	 * @see	   Byte::format()
	 * @dataProvider formatProvider
	 */
	public function testFormat($size, $expected)
	{
		$result = $this->object->format($size);

		$msg = 'Wrong Byte::format() result';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * Data-provider for testFormat
	 */
	public function formatProvider()
	{
		return array(
			array(58, '58.00 B'),
			array(10245, '10.00 KB'),
			array(10245156, '9.77 MB'),
			array(10485760, '10.00 MB'),
			array(10737418240, '10.00 GB')
		);
	}
}
