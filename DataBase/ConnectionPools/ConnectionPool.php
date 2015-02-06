<?php
namespace Veles\DataBase\ConnectionPools;

use Veles\DataBase\Connections\PdoConnection;

/**
 * Class ConnectionPool
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class ConnectionPool
{
	/** @var array */
	protected $pool;
	/** @var  string */
	protected $conn_name;

	/**
	 * @return string
	 */
	public function getDefaultConnectionName()
	{
		return $this->conn_name;
	}

	/**
	 * Add connection to connection pool
	 *
	 * @param PdoConnection $conn
	 * @param bool $default Flag is this connection default or not
	 * @return $this
	 * @see DbConnection
	 */
	public function addConnection(PdoConnection $conn, $default = false)
	{
		$this->pool[$conn->getName()] = $conn;

		if ($default) {
			$this->conn_name = $conn->getName();
		}
		return $this;
	}

	/**
	 * Get connection class by name
	 *
	 * @param string $name Connection name
	 * @return PdoConnection|null
	 * @see DbConnection
	 */
	public function getConnection($name)
	{
		return isset($this->pool[$name]) ? $this->pool[$name] : null;
	}
}
