<?php
namespace Tests\Model;

use Veles\Model\User;
use Veles\DataBase\Db;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\DbFilter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-27 at 09:28:42.
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $object;

    protected static $tbl_name;

    public static function setUpBeforeClass()
    {
        // Create test table
        $tbl_name = static::$tbl_name = User::TBL_NAME;

        Db::setAdapter(PdoAdapter::instance());
        Db::query("
			CREATE TABLE $tbl_name (
			  id int(10) unsigned NOT NULL DEFAULT '0',
			  `group` tinyint(3) unsigned NOT NULL DEFAULT '16',
			  email char(30) NOT NULL,
			  hash char(60) NOT NULL,
			  short_name char(30) NOT NULL,
			  name char(30) NOT NULL DEFAULT 'n\\a',
			  patronymic char(30) NOT NULL DEFAULT 'n\\a',
			  surname char(30) NOT NULL DEFAULT 'n\\a',
			  birth_date date NOT NULL,
			  last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (id),
			  KEY email (email)
			) ENGINE=INNODB DEFAULT CHARSET=utf8
		");
        // superpass GlOaUExBSD9HxuEYk2ZFaeDhggU716O
        Db::query("
			INSERT INTO $tbl_name
				(id, email, hash, short_name, birth_date)
			VALUES
				(?, ?, ?, ?, ?)
		", [
            1, 'mail@mail.org',
            '$2a$07$usesomesillystringforeGlOaUExBSD9HxuEYk2ZFaeDhggU716O',
            'uzzy', '1980-12-12'
        ], 'issss');
    }

    public static function tearDownAfterClass()
    {
        $table =& static::$tbl_name;
        Db::query("DROP TABLE $table");
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new User;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Veles\Model\User::getId
     */
    public function testGetId()
    {
        $expected = null;
        $result = $this->object->getId();

        $msg = 'User::getId() returns wrong result!';
        $this->assertSame($expected, $result, $msg);

        $this->object->getById(1);

        $expected = 1;
        $result = $this->object->getId();
        $this->assertSame($expected, $result, $msg);
    }

    /**
     * @covers Veles\Model\User::getHash
     */
    public function testGetHash()
    {
        $expected = null;
        $result = $this->object->getHash();

        $msg = 'User::getHash() returns wrong result!';
        $this->assertSame($expected, $result, $msg);

        $this->object->getById(1);

        $expected = '$2a$07$usesomesillystringforeGlOaUExBSD9HxuEYk2ZFaeDhggU716O';
        $result = $this->object->getHash();
        $this->assertSame($expected, $result, $msg);
    }

    /**
     * @covers Veles\Model\User::getCookieHash
     */
    public function testGetCookieHash()
    {
        $expected = null;
        $result = $this->object->getCookieHash();

        $msg = 'User::getCookieHash() returns wrong result!';
        $this->assertSame($expected, $result, $msg);

        $this->object->getById(1);

        $expected = 'GlOaUExBSD9HxuEYk2ZFaeDhggU716O';
        $result = $this->object->getCookieHash();
        $this->assertSame($expected, $result, $msg);
    }

    /**
     * @covers Veles\Model\User::getSalt
     */
    public function testGetSalt()
    {
        $expected = null;
        $result = $this->object->getSalt();

        $msg = 'User::getSalt() returns wrong result!';
        $this->assertSame($expected, $result, $msg);

        $this->object->getById(1);

        $expected = '$2a$07$usesomesillystringfor';
        $result = $this->object->getSalt();
        $this->assertSame($expected, $result, $msg);
    }

    /**
     * @covers Veles\Model\User::getGroup
     */
    public function testGetGroup()
    {
        $expected = 16;
        $result = $this->object->getGroup();

        $msg = 'User::getGroup() returns wrong result!';
        $this->assertSame($expected, $result, $msg);

        $this->object->getById(1);

        $expected = 16;
        $result = $this->object->getGroup();
        $this->assertSame($expected, $result, $msg);
    }
}