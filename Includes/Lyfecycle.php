<?php
namespace SimpleProductMilestones\Includes;

class Lyfecycle
{
	public static function activate()
	{
		do_action('SimpleProductMilestones/setup');
	}
	
	public static function deactivate()
	{

	}
	
	public static function uninstall()
	{
		do_action('SimpleProductMilestones/cleanup');
	}
}
