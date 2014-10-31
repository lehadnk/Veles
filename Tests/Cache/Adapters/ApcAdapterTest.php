<?php
namespace Tests\Cache\Adapters;

use Veles\Cache\Adapters\ApcAdapter;
use Veles\Cache\Cache;
use Veles\Cache\Adapters\MemcachedAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-10-31 at 20:11:31.
 */
class ApcAdapterTest extends \PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass()
	{
		ini_set('apc.enable_cli', 1);
		Cache::setAdapter(ApcAdapter::instance());
	}

	public static function tearDownAfterClass()
	{
		Cache::setAdapter(MemcachedAdapter::instance());
	}

	/**
	 * For each test set up adapter
	 */
	public function setUp()
	{
		$this->object = ApcAdapter::instance();
	}

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::get
     */
    public function testGet()
    {
		$params = [];

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			$this->object->set($key, $value, 10);
			$params[] = [$key, $value];
		}

		$msg = 'Wrong ApcAdapter::get() result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = $this->object->get($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::set
     */
    public function testSet()
    {
		$params = [];

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			$this->object->set($key, $value, 10);
			$params[] = [$key, $value];
		}

		$msg = 'Wrong ApcAdapter::set() result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = Cache::get($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::has
     */
    public function testHas()
    {
		$params = [];

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = [$key, true];
		}

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$params[] = [$key, false];
		}

		$msg = 'Wrong ApcAdapter::has() result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = $this->object->has($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::del
     * @todo   Implement testDel().
     */
    public function testDel()
    {
		$params = [];

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = [$key, true];
		}

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$params[] = [$key, false];
		}

		$msg = 'Wrong MemcacheAdapter::del result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = $this->object->del($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::delByTemplate
     * @todo   Implement testDelByTemplate().
     */
    public function testDelByTemplate()
    {
		$key    = uniqid('VELES::UNIT-TEST::DEL-BY-TPL::');
		$value  = mt_rand(1, 1000);
		Cache::set($key, $value, 10);

		$result = $this->object->delByTemplate('VELES::UNIT-TEST::DEL-BY-TPL::');

		$msg = 'ApcAdapter::delByTemplate() return wrong result!';
		$this->assertSame(true, $result, $msg);

		$result = $this->object->has($key);
		$msg = 'Key was not deleted by template!';
		$this->assertSame(false, $result, $msg);

		$result = $this->object->delByTemplate('EnyKey');

		$msg = 'Wrong ApcAdapter::delByTemplate() behavior!';
		$this->assertSame(false, $result, $msg);
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::clear
     * @todo   Implement testClear().
     */
    public function testClear()
    {
		$params = [];

		for ($i = 0; $i < 10; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = $key;
		}

		$result = $this->object->clear();

		$msg = 'Wrong ApcAdapter::clear() result!';
		$this->assertSame(true, $result, $msg);

		$expected = false;
		$msg = 'Cache was not cleared!';

		foreach ($params as $key) {
			$result = Cache::has($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::increment
     * @todo   Implement testIncrement().
     */
    public function testIncrement()
    {
		$key    = uniqid('VELES::UNIT-TEST::');
		$value  = mt_rand(0, 1000);
		Cache::set($key, $value, 10);
		$params = [[$key, null, ++$value]];

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('VELES::UNIT-TEST::');
			$value  = mt_rand(0, 1000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = [$key, $offset, $value + $offset];
		}

		foreach ($params as $param) {
			list($key, $offset, $expected) = $param;

			$result = (null === $offset)
				? $this->object->increment($key, 1)
				: $this->object->increment($key, $offset);

			$msg = 'ApcAdapter::increment() returned wrong result type!';
			$this->assertInternalType('integer', $result, $msg);
			$msg = 'ApcAdapter::increment() returned wrong result value!';
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\ApcAdapter::decrement
     * @todo   Implement testDecrement().
     */
    public function testDecrement()
    {
		$key    = uniqid('VELES::UNIT-TEST::');
		$value  = mt_rand(1, 1000);
		Cache::set($key, $value, 10);
		$params = [[$key, null, --$value]];

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('VELES::UNIT-TEST::');
			$value  = mt_rand(1000, 2000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = [$key, $offset, $value - $offset];
		}

		foreach ($params as $param) {
			list($key, $offset, $expected) = $param;
			$result = (null === $offset)
				? $this->object->decrement($key, 1)
				: $this->object->decrement($key, $offset);

			$msg = 'ApcAdapter::decrement() returned wrong result type!';
			$this->assertInternalType('integer', $result, $msg);
			$msg = 'ApcAdapter::decrement() returned wrong result value!';
			$this->assertSame($expected, $result, $msg);
		}
    }
}
