<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcacheRaw;
use Veles\Cache\Adapters\MemcacheAdapter;
use Veles\Cache\Cache;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-06 at 15:06:37.
 */
class MemcacheAdapterTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @var MemcacheAdapter
     */
    protected $object;

	public static function setUpBeforeClass()
	{
		Cache::setAdapter('Memcache');
	}

	public static function tearDownAfterClass()
	{
		Cache::setAdapter();
		MemcacheRaw::setConnectionParams('localhost', 11211);
	}

	/**
	 * For each test set up adapter
	 */
	public function setUp()
	{
		$this->object = Cache::getAdapter();
	}

	/**
	 * @covers Veles\Cache\Adapters\MemcacheAdapter::__construct
	 */
	public function testInstance()
	{
		$object = MemcacheAdapterChild::getTestInstance();
		$result = $object->getDriverForTest();
		$expected = 'Memcache';
		$msg = 'Wrong result driver inside MemcacheAdapter!';
		$this->assertInstanceOf($expected, $result, $msg);
	}

	/**
     * @covers Veles\Cache\Adapters\MemcacheAdapter::get
     */
    public function testGet()
    {
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = array($key, $value);
		}

		$msg = 'Wrong MemcachedAdapter::get result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = $this->object->get($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\MemcacheAdapter::set
     */
    public function testSet()
    {
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			$this->object->set($key, $value, 10);
			$params[] = array($key, $value);
		}

		$msg = 'Wrong MemcacheAdapter::set result!';
		foreach ($params as $param) {
			$result = $this->object->get($param[0]);
			$this->assertSame($param[1], $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\MemcacheAdapter::has
     */
    public function testHas()
    {
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = array($key, true);
		}

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$params[] = array($key, false);
		}

		$msg = 'Wrong MemcacheAdapter::has result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = $this->object->has($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\MemcacheAdapter::del
     */
    public function testDel()
    {
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = array($key, true);
		}

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$params[] = array($key, false);
		}

		$msg = 'Wrong MemcacheAdapter::del result!';
		foreach ($params as $param) {
			list($key, $expected) = $param;
			$result = $this->object->del($key);
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\MemcacheAdapter::increment
     */
    public function testIncrement()
    {
		$key    = uniqid('VELES::UNIT-TEST::');
		$value  = mt_rand(0, 1000);
		Cache::set($key, $value, 10);
		$params = array(array($key, null, ++$value));

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('VELES::UNIT-TEST::');
			$value  = mt_rand(0, 1000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = array($key, $offset, $value + $offset);
		}

		foreach ($params as $param) {
			list($key, $offset, $expected) = $param;

			$result = (null === $offset)
				? $this->object->increment($key, 1)
				: $this->object->increment($key, $offset);

			$msg = 'MemcacheAdapter::increment returned wrong result type!';
			$this->assertInternalType('integer', $result, $msg);
			$msg = 'MemcacheAdapter::increment returned wrong result value!';
			$this->assertSame($expected, $result, $msg);
		}
    }

    /**
     * @covers Veles\Cache\Adapters\MemcacheAdapter::decrement
     */
    public function testDecrement()
    {
		$key    = uniqid('VELES::UNIT-TEST::');
		$value  = mt_rand(1, 1000);
		Cache::set($key, $value, 10);
		$params = array(array($key, null, --$value));

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('VELES::UNIT-TEST::');
			$value  = mt_rand(1000, 2000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = array($key, $offset, $value - $offset);
		}

		foreach ($params as $param) {
			list($key, $offset, $expected) = $param;
			$result = (null === $offset)
				? $this->object->decrement($key, 1)
				: $this->object->decrement($key, $offset);

			$msg = 'MemcacheAdapter::decrement returned wrong result type!';
			$this->assertInternalType('integer', $result, $msg);
			$msg = 'MemcacheAdapter::decrement returned wrong result value!';
			$this->assertSame($expected, $result, $msg);
		}
    }

	/**
	 * @covers Veles\Cache\Adapters\MemcacheAdapter::clear
	 */
	public function testClear()
	{
		$params = array();

		for ($i = 0; $i < 10; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			$this->object->set($key, $value, 10);
			$params[] = $key;
		}

		$result = $this->object->clear();

		$msg = 'Wrong MemcacheAdapter::clear() result!';
		$this->assertSame(true, $result, $msg);

		$result = false;
		foreach ($params as $key) {
			if ($this->object->get($key)) $result = true;
		}

		$msg = 'Cache was not cleared!';
		$this->assertSame(false, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Adapters\MemcacheAdapter::delByTemplate
	 */
	public function testDelByTemplate()
	{
		$key    = uniqid('VELES::UNIT-TEST::DEL-BY-TPL::');
		$value  = mt_rand(1, 1000);
		$this->object->set($key, $value, 10);

		$result = $this->object->delByTemplate('VELES::UNIT-TEST::DEL-BY-TPL::');

		$msg = 'Cache::delByTemplate return wrong result!';
		$this->assertSame(true, $result, $msg);

		$result = $this->object->has($key);
		$msg = 'Key was not deleted by template!';
		$this->assertSame(false, $result, $msg);

		MemcacheRaw::setConnectionParams('localhost', 11213);
		$result = $this->object->delByTemplate('EnyKey');

		$msg = 'Wrong MemcacheAdapter::delByTemplate behavior!';
		$this->assertSame(false, $result, $msg);
	}
}
