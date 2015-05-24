<?php
namespace Veles\Tests\DataBase\Exceptions;

use Veles\DataBase\Exceptions\DbException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-01 at 11:13:18.
 */
class DbExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DbException
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$msg = "SQLSTATE[28000] [1045] Access denied for user 'user'@'localhost' (using password: YES)";
		$code = 28000;

		$exception = new \PDOException($msg, $code);
		$this->object = new DbException($msg, $code, $exception);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\DataBase\Exceptions\DbException::__construct
	 *
	 * @param string $message
	 * @param string $ansi_code
	 * @param int $code
	 * @param \PDOException $exception
	 *
	 * @dataProvider constructProvider
	 */
	public function testConstruct($message, $ansi_code, $code, $exception)
	{
		$obj = new DbException(
			$exception->getMessage(), (int) $exception->getCode(), $exception
		);

		$result = $obj->getMessage();
		$msg = 'Wrong DbException::__construct() behavior!';
		$this->assertSame($message, $result, $msg);

		$result = $obj->getAnsiCode();
		$msg = 'Wrong DbException::__construct() behavior!';
		$this->assertSame($ansi_code, $result, $msg);

		$result = $obj->getCode();
		$msg = 'Wrong DbException::__construct() behavior!';
		$this->assertSame($code, $result, $msg);
	}

	public function constructProvider()
	{
		return [
			["Unknown column 'contest' in 'where clause'", '42S22', 1054, new \PDOException("SQLSTATE[42S22]: Column not found: 1054 Unknown column 'contest' in 'where clause'", (int) '42S22')],
			["You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ORDER BY minimum
						LIMIT 1' at line 7", '42000', 1064, new \PDOException("SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ORDER BY minimum
						LIMIT 1' at line 7", (int) '42000')],
			["Access denied for user 'root'@'localhost' (using password: YES)", '28000', 1045, new \PDOException("SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: YES)", (int) '28000')],
			["Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (2)", 'HY000', 2002, new \PDOException("SQLSTATE[HY000] [2002] Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (2)", (int) 'HY000')]
		];
	}

	/**
	 * @covers Veles\DataBase\Exceptions\DbException::getAnsiCode
	 */
	public function testGetAnsiCode()
	{
		$expected = '28000';
		$result = $this->object->getAnsiCode();
		$msg = 'DbException::getAnsiCode returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\DataBase\Exceptions\DbException::setAnsiCode
	 */
	public function testSetAnsiCode()
	{
		$expected = uniqid();
		$this->object->setAnsiCode($expected);
		$result = $this->object->getAnsiCode();
		$msg = 'DbException::setAnsiCode wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}
}
