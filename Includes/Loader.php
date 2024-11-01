<?php
namespace SimpleProductMilestones\Includes;

class Loader
{
	protected $plugin_name;
	protected $plugin_version;

	public function __construct()
	{
		$this->plugin_version = defined('SIMPLEPRODUCTMILESTONES_VERSION') ? SIMPLEPRODUCTMILESTONES_VERSION : '1.0.0';
		$this->plugin_name = 'simple-product-milestones';
		$this->load_dependencies();

		add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);
		add_action('wp_enqueue_scripts', [$this, 'load_assets'], 100);
	}

	private function load_dependencies()
	{
		foreach (glob(SIMPLEPRODUCTMILESTONES_PATH . 'Functionality/*.php') as $filename) {
			$class_name = '\\SimpleProductMilestones\Functionality\\'. basename($filename, '.php');
			if (class_exists($class_name)) {
				try {
					new $class_name($this->plugin_name, $this->plugin_version);
				}
				catch (\Throwable $e) {
					pb_log($e);
					continue;
				}
			}
		}
	}

	public function load_plugin_textdomain()
	{
		load_plugin_textdomain('simple-product-milestones', false, SIMPLEPRODUCTMILESTONES_BASENAME . '/languages/');
	}

	public function load_assets()
	{
		wp_enqueue_style('simple-product-milestones/app.css', SIMPLEPRODUCTMILESTONES_URL . 'dist/app.css', false, $this->plugin_version);
		wp_enqueue_script('eloquent-clicks-core/app.js', SIMPLEPRODUCTMILESTONES_URL . 'dist/app.js', [], $this->plugin_version, true);
	}
}
