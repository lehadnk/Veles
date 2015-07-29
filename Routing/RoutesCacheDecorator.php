<?php
/**
 * Class for routes config caching
 *
 * @file      RoutesCacheDecorator.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-05-24 20:14
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

use Veles\Cache\Cache;

/**
 * Class RoutesCacheDecorator
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RoutesCacheDecorator extends AbstractRoutesConfig
{
	protected $config;
	/** @var  string */
	protected $prefix;

	public function __construct(RoutesConfig $config)
	{
		$this->config = $config;
	}

	/**
	 * Returns array that contains routes configuration
	 *
	 * @return array
	 */
	public function getData()
	{
		if (false !== ($data = Cache::get($this->getPrefix()))) {
			return $data;
		}

		$data = $this->config->getData();
		Cache::set($this->getPrefix(), $data);

		return $data;
	}

	/**
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * @param string $prefix
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}
}