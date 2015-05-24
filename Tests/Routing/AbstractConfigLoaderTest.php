<?php
namespace Veles\Tests\Routing;

use Veles\Routing\AbstractConfigLoader;
use Veles\Routing\IniConfigLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 17:59:59.
 */
class AbstractConfigLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var AbstractConfigLoader
	 */
	protected $object;
	protected $path;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->path = TEST_DIR . '/Project/routes.ini';
		$this->object = new IniConfigLoader($this->path);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Routing\AbstractConfigLoader::__construct
	 */
	public function testConstruct()
	{
		$msg = 'AbstractConfigLoader::__construct() wrong behavior!';
		$this->assertAttributeSame($this->path, 'path', $this->object, $msg);
	}

	/**
	 * @covers Veles\Routing\AbstractConfigLoader::getPath
	 */
	public function testGetPath()
	{
		$result = $this->object->getPath();
		$msg = 'AbstractConfigLoader::getPath() return wrong result!';
		$this->assertSame($this->path, $result, $msg);
	}
}
