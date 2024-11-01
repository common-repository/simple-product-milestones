<?php

namespace SimpleProductMilestones\Includes;

use Jenssegers\Blade\Blade;

class BladeLoader
{
	private static $instance = NULL;
	private $blade;

	private function __construct()
	{
		$this->blade = new Blade(SIMPLEPRODUCTMILESTONES_PATH . 'resources/views', SIMPLEPRODUCTMILESTONES_PATH . 'resources/cache');
	}

	// Clone not allowed
	private function __clone()
	{
	}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new BladeLoader();
		}
		return self::$instance;
	}

	public function make_directive(string $name, callable $handler)
	{
		$this->blade->directive($name, $handler);
	}

	public function template($name, $args = [])
	{
		return $this->blade->render($name, $args);
	}
}
