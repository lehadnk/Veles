<?php
/**
 * Юнит-тест для класса UsrGroup
 * @file    UsrGroupTest.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Янв 25 20:56:16 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests\Auth;

use PHPUnit_Framework_TestCase;
use Veles\Auth\UsrGroup;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-25 at 20:55:11.
 */
class UsrGroupTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for UsrGroup class
	 * @group Auth
	 */
	public function testConstants()
	{
		$msg = 'Wrong UsrGroup::ADMIN value';
		$this->assertSame(1, UsrGroup::ADMIN, $msg);

		$msg = 'Wrong UsrGroup::MANAGER value';
		$this->assertSame(2, UsrGroup::MANAGER, $msg);

		$msg = 'Wrong UsrGroup::MODERATOR value';
		$this->assertSame(4, UsrGroup::MODERATOR, $msg);

		$msg = 'Wrong UsrGroup::REGISTERED value';
		$this->assertSame(8, UsrGroup::REGISTERED, $msg);

		$msg = 'Wrong UsrGroup::GUEST value';
		$this->assertSame(16, UsrGroup::GUEST, $msg);

		$msg = 'Wrong UsrGroup::DELETED value';
		$this->assertSame(32, UsrGroup::DELETED, $msg);
	}
}
