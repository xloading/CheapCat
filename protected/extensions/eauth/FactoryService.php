<?php
class FactoryService
{
	private static $_cache;

	public static function get($serviceName)
	{
		if (!$serviceName) {
			throw new Exception("Service name is not define");
		}

		if (isset(self::$_cache[$serviceName])) {
			return self::$_cache[$serviceName];
		}

		$className = ucfirst($serviceName) . 'Service';

		if (!class_exists($className)) {
			throw new Exception("Service not exists");
		}

		$service = new $className();
		self::$_cache[$serviceName] = $service;

		return $service;
	}
}
?>