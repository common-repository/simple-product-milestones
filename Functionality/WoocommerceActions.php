<?php
namespace SimpleProductMilestones\Functionality;

class WoocommerceActions
{

	protected $plugin_name;
	protected $plugin_version;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;

		add_filter( 'woocommerce_product_data_tabs', [$this, 'add_woocommerce_tabs'] );
		add_action( 'woocommerce_before_add_to_cart_form', [$this, 'add_milestones'] );
	}

	public function add_woocommerce_tabs($tabs)
	{
		$tabs['milestones'] = array(
			'label' 	=> 'Milestones',
			'target' 	=> 'milestones'
		);

		return $tabs;
	}

	public function add_milestones() {
		echo wp_kses_post( do_shortcode( '[simple-product-milestones]' ) );
	}
}
