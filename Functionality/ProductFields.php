<?php
namespace SimpleProductMilestones\Functionality;

use \CPF\Section\Section;
use \CPF\Field\RepeatableField;
use \CPF\Field\Field;

class ProductFields
{

	protected $plugin_name;
	protected $plugin_version;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;

		add_action('after_setup_theme', [$this, 'load_cpf']);
		add_action('cpf_register_fields', [$this, 'register_fields']);
	}

	public function load_cpf()
	{
		\CPF\Loader::load();
	}

	public function register_fields()
	{
		Section::create('milestones_section', 'Milestones', [

			// STEPS
			RepeatableField::create('milestone-complex', 'Milestones', [
				Field::create('text', 'step_name', __('Step Name', 'single-product-milestones')),
				Field::create('textarea', 'step_description', __('Step Description', 'single-product-milestones')),
				Field::create('checkbox', 'completed_step', __('Completed', 'single-product-milestones')),
				Field::create('text', 'step_link', __('Step Link', 'single-product-milestones'))
			]),

			// COLOR
			Field::create('color', 'milestone_color', __('Milestone Color', 'single-product-milestones'))
				->default_value('#17C7FF'),

			Field::create('color', 'milestone_bg_color', __('Milestone Circle Color', 'single-product-milestones'))
				->default_value('#000000'),

			Field::create('color', 'milestone_uncompleted_color', __('Uncompleted Step Color', 'single-product-milestones'))
				->default_value('#FFFFDF'), //TODO: PENSAR UN COLOR QUE QUEDI MILLOR

			Field::create('color', 'uncompleted_text_color', __('Uncompleted Step Text Color', 'single-product-milestones'))
				->default_value('#2C2935'),

			// ADVANCED
			Field::create('number', 'milestone_starting_number', __('Starting Number', 'single-product-milestones'))
				->default_value(1)
				->step(1),

			Field::create('checkbox', 'milestone_pulse', __('Current Step Pulse Animation', 'single-product-milestones'))
				->default_value('1'),

			Field::create('select', 'milestone_orientation', __('Orientation', 'single-product-milestones'))
				->add_options([
					'responsive' 	=> __('Responsive', 'single-product-milestones'),
					'horizontal' 	=> __('Horizontal', 'single-product-milestones'),
					'vertical'		=> __('Vertical', 'single-product-milestones')
				])
				->default_value('responsive'),
			
			
			Field::create('checkbox', 'milestone_line', __('Show Milestone Line', 'single-product-milestones'))
				->default_value('1'),

			// STEP DESIGN (POTSER AFEGIR DIFERENTS)?
		])
			->if_tab('milestones');
	}
}
