<?php

namespace SimpleProductMilestones\Functionality;

use SimpleProductMilestones\Includes\BladeLoader;

class Shortcodes
{

	protected $plugin_name;
	protected $plugin_version;

	private $blade;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;
		$this->blade = BladeLoader::getInstance();

		add_action('init', [$this, 'add_shortcodes']);
	}

	public function add_shortcodes()
	{
		add_shortcode( 'simple-product-milestones', [$this, 'add_milestones'] );
		return;
	}

	public function load_milestones() {

		$product_id = get_the_ID();

		$milestone_complex_tabs = get_post_meta( $product_id, '_milestone-complex', true );
		if (!$milestone_complex_tabs) return [];

		$milestones = [];
		for ($tab = 0; $tab < $milestone_complex_tabs; $tab++) {
			$milestones[] = [
				'step_name'			=> get_post_meta( $product_id, '_milestone-complex_' . $tab . '_step_name', true ),
				'step_description'	=> get_post_meta( $product_id, '_milestone-complex_' . $tab . '_step_description', true ),
				'completed_step'	=> get_post_meta( $product_id, '_milestone-complex_' . $tab . '_completed_step', true ),
				'step_link'			=> get_post_meta( $product_id, '_milestone-complex_' . $tab . '_step_link', true )
			];
		}
		return $milestones;
	}

	public function add_milestones() {

		$product_id 							= get_the_ID();
		$milestones 							= $this->load_milestones();
		$milestone_color 						= get_post_meta( $product_id, '_milestone_color', true );
		$milestone_bg_color 					= get_post_meta( $product_id, '_milestone_bg_color', true );
		$milestone_uncompleted_color 			= get_post_meta( $product_id, '_milestone_uncompleted_color', true );
		$milestone_uncompleted_text_color		= get_post_meta( $product_id, '_uncompleted_text_color', true );
		$milestone_starting_number				= get_post_meta( $product_id, '_milestone_starting_number', true );
		$milestone_pulse						= get_post_meta( $product_id, '_milestone_pulse', true );
		$milestone_orientation					= get_post_meta( $product_id, '_milestone_orientation', true );
		$milestone_line							= get_post_meta( $product_id, '_milestone_line', true );
		
		if (!$milestones) return;
		if (!$milestone_color) 					$milestone_color = "#17C7FF";
		if (!$milestone_bg_color) 				$milestone_bg_color = "#000000";
		if (!$milestone_uncompleted_color)  	$milestone_uncompleted_color = "#FFFFDF";
		if (!$milestone_uncompleted_text_color)	$milestone_uncompleted_text_color = "#2C2935";
		if (!$milestone_starting_number)		$milestone_starting_number = 1;
		if (!$milestone_pulse === '')			$milestone_pulse = 1;
		if (!$milestone_orientation)			$milestone_orientation = 'responsive';
		if (!$milestone_line === '')			$milestone_line = 1;

		$milestone_classes = array(
			'responsive'=> array(
				'ul' 	=> "pb-steps pb-steps-vertical lg:pb-steps-horizontal pb-m-0 pb-pl-4 lg:pb-pl-0 lg:pb-pt-4 !pb-overflow-visible lg:!pb-w-full lg:!pb-mb-12 pb-gap-3 lg:pb-gap-0",
				'li' 	=> "pb-step before:pb-w-[0.2rem] lg:before:pb-w-full lg:before:!pb-h-[0.2rem] after:!pb-font-bold !pb-relative after:!pb-w-12 after:!pb-h-12 pb-gap-3",
				'div'	=> "pb-tooltip pb-tooltip-right lg:pb-tooltip-bottom",
				'span'	=> "pb-absolute pb-w-10 pb-h-10 pb-top-3 lg:pb-top-0 pb-left-0 lg:pb-left-auto pb-rounded-full pb-animate-ping"
			),
			'horizontal'=> array(
				'ul' 	=> "pb-steps pb-steps-horizontal pb-pl-0 pb-pt-4 !pb-w-full !pb-mb-12",
				'li' 	=> "pb-step before:pb-w-full before:!pb-h-[0.2rem] after:!pb-font-bold !pb-relative after:!pb-w-12 after:!pb-h-12 pb-gap-3",
				'div'	=> "pb-tooltip pb-tooltip-bottom",
				'span'	=> "pb-absolute pb-w-10 pb-h-10 pb-top-0 pb-left-auto pb-rounded-full pb-animate-ping"
			),
			'vertical'	=> array(
				'ul' 	=> "pb-steps pb-steps-vertical pb-m-0 pb-pl-4 !pb-overflow-visible pb-gap-3",
				'li' 	=> "pb-step before:pb-w-[0.2rem] after:!pb-font-bold !pb-relative after:!pb-w-12 after:!pb-h-12 pb-gap-3",
				'div'	=> "pb-tooltip pb-tooltip-right",
				'span'	=> "pb-absolute pb-w-10 pb-h-10 pb-top-3 pb-left-0 pb-rounded-full pb-animate-ping"
			)
		);

		ob_start(); ?>

		<ul class="<?php echo esc_attr( $milestone_classes[$milestone_orientation]['ul'] ); ?>">
			<?php foreach ($milestones as $key => $milestone): ?>
				<?php $next_to_complete = !$milestone['completed_step'] && (!isset($milestones[$key - 1]) || $milestones[$key - 1]['completed_step']); ?>
				<li data-content="<?php echo esc_attr( $milestone['completed_step'] ? '✓' : $milestone_starting_number + $key ); ?>" class="<?php echo esc_attr( $milestone_classes[$milestone_orientation]['li'] . (($milestone['completed_step'] || $next_to_complete) ? ' after:!pb-border-2 after:!pb-border-solid' : ' pb-uncompleted-step') . ($milestone_line ? '' : ' before:!pb-hidden') ); ?>" style="<?php echo esc_attr( ($milestone['completed_step'] || $next_to_complete) ? '--chosen-color: ' . $milestone_color . '; --chosen-bg-color: ' . $milestone_bg_color . '; color: ' . $milestone_color . ';' : '--chosen-uncompleted-color: ' . $milestone_uncompleted_color . '; --chosen-uncompleted-text-color: ' . $milestone_uncompleted_text_color . ';' ); ?>">
					<div class="<?php echo esc_attr( $milestone['step_description'] ? $milestone_classes[$milestone_orientation]['div'] : '' ); ?>" data-tip="<?php echo esc_attr( $milestone['step_description'] ); ?>">
						<?php if ($milestone['step_link']): ?>
							<a href="<?php echo esc_url($milestone['step_link']); ?>" class="pb-m-0 pb-cursor-pointer" <?php echo ($milestone['completed_step'] || $next_to_complete) ? '' : 'style="color: ' . esc_attr( $milestone_uncompleted_color ) . '"'; ?>><?php echo wp_kses_post( $milestone['step_name'] ); ?></a>
						<?php else: ?>
							<p class="pb-m-0 <?php echo esc_attr( $milestone['step_description'] ? 'pb-cursor-help' : '' ); ?>" <?php echo ($milestone['completed_step'] || $next_to_complete) ? '' : 'style="color: ' . esc_attr( $milestone_uncompleted_color ) . '"'; ?>><?php echo wp_kses_post( $milestone['step_name'] ); ?></p>
						<?php endif; ?>
					</div>
					<?php if ($next_to_complete && $milestone_pulse): ?>
						<span class="<?php echo esc_attr( $milestone_classes[$milestone_orientation]['span'] ); ?>" style="background-color: <?php echo esc_attr( $milestone_color ); ?>"></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php $milestones = ob_get_clean();
		return $milestones;

	}
}
