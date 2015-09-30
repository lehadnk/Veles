<?php
namespace Veles\Tests\Auth;

use Veles\Auth\UsrGroup;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-24 at 16:37:03.
 */
class UsrAuthTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Veles\Auth\UsrAuth
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = UsrAuthCopy::instance();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Auth\UsrAuth::instance
	 * @covers Veles\Auth\UsrAuth::__construct
	 */
	public function testInstance()
	{
		UsrAuthCopy::unsetInstance();

		$expected = '\Veles\Auth\UsrAuth';
		$result = UsrAuthCopy::instance();
		$msg = 'UsrAuth::instance() return wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Auth\UsrAuth::getErrors
	 */
	public function testGetErrors()
	{
		$expected = 0;
		$result = $this->object->getErrors();
		$msg = 'UsrAuth::getErrors returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Auth\UsrAuth::hasAccess
	 * @dataProvider testHasAccessProvider
	 */
	public function testHasAccess($group, $expected)
	{
		$result = $this->object->hasAccess([$group]);
		$msg = 'UsrAuth::hasAccess() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function testHasAccessProvider()
	{
		return [
			[UsrGroup::ADMIN, false],
			[UsrGroup::DELETED, false],
			[UsrGroup::GUEST, true],
			[UsrGroup::MANAGER, false],
			[UsrGroup::MODERATOR, false],
			[UsrGroup::REGISTERED, false]
		];
	}

	/**
	 * @covers Veles\Auth\UsrAuth::getUser
	 */
	public function testGetUser()
	{
		$expected = '\Veles\Model\User';
		$result = $this->object->getUser();
		$msg = 'UsrAuth::getUser() returns wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);
	}
}
