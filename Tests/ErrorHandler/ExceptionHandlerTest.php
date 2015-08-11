<?php
namespace Veles\Tests\ErrorHandler;

use Veles\ErrorHandler\ExceptionHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-08-11 at 19:46:34.
 * @group ErrorHandler
 */
class ExceptionHandlerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var ExceptionHandler
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new ExceptionHandler;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers       Veles\ErrorHandler\ExceptionHandler::run
	 * @dataProvider runProvider
	 *
	 * @param $e
	 * @param $expected
	 */
	public function testRun($e, $expected)
	{
		$this->object->run($e);

		$result = $this->object->getVars();

		$msg = 'ExceptionHandler::run() wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	public function runProvider()
	{
		$msg = 'runProvider Exception';
		try {
			throw new \Exception($msg);
		} catch(\Exception $e) {}

		$time = time();
		$_SERVER['REQUEST_TIME'] = $time;
		$expected = [
			'time' => strftime('%Y-%m-%d %H:%M:%S', $time),
			'message' => $msg,
			'file' => realpath(__FILE__),
			'line' => 55,
			'stack' => array_reverse($e->getTrace()),
			'type' => 0,
			'defined' => []
		];

		return [
			[$e, $expected]
		];
	}
}