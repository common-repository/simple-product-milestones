<?php

/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Product Milestones
 * Plugin URI:        https://sirvelia.com/
 * Description:       Create and customize milestones for your WooCommerce products.
 * Version:           1.0.0
 * Author:            Sirvelia
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       simple-product-milestones
 * Domain Path:       /languages
 */

// Direct access, abort.
if (!defined('WPINC')) {
	die('YOU SHALL NOT PASS!');
}

define('SIMPLEPRODUCTMILESTONES_VERSION', '1.0.0');
define('SIMPLEPRODUCTMILESTONES_PATH', plugin_dir_path(__FILE__));
define('SIMPLEPRODUCTMILESTONES_BASENAME', plugin_basename(__FILE__));
define('SIMPLEPRODUCTMILESTONES_URL', plugin_dir_url(__FILE__));

require_once SIMPLEPRODUCTMILESTONES_PATH . 'vendor/autoload.php';

register_activation_hook(__FILE__, [SimpleProductMilestones\Includes\Lyfecycle::class, 'activate']);
register_deactivation_hook(__FILE__, [SimpleProductMilestones\Includes\Lyfecycle::class, 'deactivate']);
register_uninstall_hook(__FILE__, [SimpleProductMilestones\Includes\Lyfecycle::class, 'uninstall']);

//LOAD ALL PLUGIN FILES
$loader = new SimpleProductMilestones\Includes\Loader();