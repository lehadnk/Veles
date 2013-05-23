<?php
/**
 * Unit-test for View class
 * @file    ViewTest.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 20 18:40:31 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests\View;

use Exception;
use PHPUnit_Framework_TestCase;
use Veles\View\View;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 18:39:47.
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Container for View object
	 * @var View
	 */
	protected $object;

	/**
	 * File name of template
	 * @var string
	 */
	protected $tpl;

	/**
	 * Final HTML output
	 * @var string
	 */
	protected $html;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new View;
		$this->tpl = 'Frontend/index.phtml';

		$this->html = <<<EOF
<!DOCTYPE html>
<html>
<head>
	<title>Veles is a fast PHP framework</title>
</head>
<body>
	<div id="main_wrapper">
		Test complete!
	</div>
	<div id="footer_wrapper">
		Hello World!
	</div>
</body>
</html>

EOF;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * Unit-test for View::set
	 *
	 * @covers View::set
	 * @dataProvider setExceptionProvider
	 * @expectedException Exception
	 * @expectedExceptionMessage View can set variables only in arrays!
	 * @see View::set
	 */
	public function testSetException($vars)
	{
		$this->object->set($vars);
	}

	/**
	 * DataProvider for VewTest::testSetException
	 */
	public function setExceptionProvider()
	{
		return array(array(1, array(1)));
	}

	/**
	 * Unit-test for View::set
	 * @covers View::set
	 * @dataProvider setProvider
	 * @see View::set
	 */
	public function testSet($vars)
	{
		$this->object->set($vars);

		$this->expectOutputString($this->html);

		$this->object->show($this->tpl);
	}

	/**
	 * DataProvider for View::set
	 */
	public function setProvider()
	{
		return array(
			array(
				array('a' => 'Test', 'b' => 'complete', 'c' => 'Hello')
			)
		);
	}

	/**
	 * Unit-test for View::show
	 * @covers View::show
	 * @depends testSet
	 * @see View::show
	 */
	public function testShow()
	{
		$this->expectOutputString($this->html);

		$this->object->show($this->tpl);
	}

	/**
	 * Unit-test for View::get
	 * @covers View::get
	 * @depends testSet
	 * @see View::get
	 */
	public function testGet()
	{
		$expected =& $this->html;

		$result = $this->object->get($this->tpl);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('string', $result, $msg);

		$msg = 'Wrong content of HTML in View::get()';
		$this->assertSame($expected, $result, $msg);
	}
}
