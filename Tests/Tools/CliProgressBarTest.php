<?php
namespace Veles\Tests\Tools;

use Veles\Tools\CliProgressBar;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-12-05 at 18:40:31.
 * @group tools
 */
class CliProgressBarTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var CliProgressBar
	 */
	protected $object;
	protected $final = 60;
	protected $width = 60;
	protected $time_before_init;
	protected $time_after_init;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->time_before_init = microtime(true);
		$this->object = new CliProgressBar($this->final);
		$this->time_after_init = microtime(true);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Tools\CliProgressBar::__construct
	 */
	public function testConstruct()
	{
		$expected = $this->final;
		$msg = 'CliProgressBar::__construct wrong behavior!';
		$this->assertAttributeSame($expected, 'final_value', $this->object, $msg);

		$expected = $this->width;
		$this->assertAttributeSame($expected, 'width', $this->object, $msg);

		$expected = $this->width / 100;
		$this->assertAttributeSame($expected, 'bp_percent', $this->object, $msg);

		$expected = $this->final / 100;
		$this->assertAttributeSame($expected, 'percent', $this->object, $msg);

		$expected = null;
		$this->assertAttributeNotEquals($expected, 'start_time', $this->object, $msg);
		$expected = 'float';
		$this->assertAttributeInternalType($expected, 'start_time', $this->object, $msg);

		$this->assertAttributeGreaterThan($this->time_before_init, 'start_time', $this->object, $msg);
		$this->assertAttributeLessThan($this->time_after_init, 'start_time', $this->object, $msg);

		$expected = $this->getObjectAttribute($this->object, 'start_time');
		$this->assertAttributeSame($expected, 'last_update_time', $this->object, $msg);
	}

	/**
	 * @covers Veles\Tools\CliProgressBar::update
	 * @covers Veles\Tools\CliProgressBar::calcParams
	 */
	public function testUpdateOne()
	{
		$mem_string = 'mem-string';
		$stat_string = 'stat-string';
		$status = $stat_string . $mem_string;
		$end = "\033[K\r";

		$this->object = $this->getMockBuilder('\Veles\Tools\CliProgressBar')
			->setConstructorArgs([60])
			->setMethods(['getStatusString', 'getMemString'])
			->getMock();
		$this->object->expects($this->once())
			->method('getStatusString')
			->willReturn($stat_string);
		$this->object->expects($this->once())
			->method('getMemString')
			->willReturn($mem_string);

		$this->expectOutputString("\033[?25l[=>\033[59C]$status$end");
		$this->object->update(1);
	}

	/**
	 * @covers Veles\Tools\CliProgressBar::update
	 * @covers Veles\Tools\CliProgressBar::calcParams
	 */
	public function testUpdateTwo()
	{
		$mem_string = 'mem-string';
		$stat_string = 'stat-string';
		$status = $stat_string . $mem_string;
		$bar = '============================================================';
		$end = "\033[K\n";

		$this->object = $this->getMockBuilder('\Veles\Tools\CliProgressBar')
			->setConstructorArgs([60])
			->setMethods(['getStatusString', 'getMemString'])
			->getMock();
		$this->object->expects($this->once())
			->method('getStatusString')
			->willReturn($stat_string);
		$this->object->expects($this->once())
			->method('getMemString')
			->willReturn($mem_string);

		$this->expectOutputString("[$bar>]$status$end\033[?25h");
		$this->object->update(60);
	}

	/**
	 * @covers Veles\Tools\CliProgressBar::getStatusString
	 */
	public function testGetStatusString()
	{
		$reflection = new \ReflectionClass($this->object);
		$clean_process_time_prop = $reflection->getProperty('clean_process_time');
		$clean_process_time_prop->setAccessible(true);
		$clean_process_time_prop->setValue($this->object, 0.1);

		$cycle_time_prop = $reflection->getProperty('cycle_time');
		$cycle_time_prop->setAccessible(true);
		$cycle_time_prop->setValue($this->object, 0.1);

		$final_value_prop = $reflection->getProperty('final_value');
		$final_value_prop->setAccessible(true);
		$final_value_prop->setValue($this->object, 100);

		$expected = " 1 u | 10 u/s | Est: 9.9 s";
		$result = $this->object->getStatusString(1);

		$msg = 'CliProgressBar::getStatusString() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Tools\CliProgressBar::getMemString
	 */
	public function testGetMemString()
	{
		$reflection = new \ReflectionClass($this->object);
		$mem_usage_func_prop = $reflection->getProperty('mem_usage_func');
		$mem_usage_func_prop->setAccessible(true);
		$mem_usage_func_prop->setValue($this->object, '\Veles\Tests\Tools\fake_mem_usage');

		$mem_peak_func_prop = $reflection->getProperty('mem_peak_func');
		$mem_peak_func_prop->setAccessible(true);
		$mem_peak_func_prop->setValue($this->object, '\Veles\Tests\Tools\fake_mem_peak_usage');

		$expected = " | Mem: 195.48 KB | Max: 215.12 KB";
		$result = $this->object->getMemString();
		$msg = 'CliProgressBar::getMemString() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}

function fake_mem_usage()
{
	return 200176;
}

function fake_mem_peak_usage()
{
	return 220285;
}