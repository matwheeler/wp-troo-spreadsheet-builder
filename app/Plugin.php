<?php 

namespace TrooSpreadsheetBuilder;

// use TrooSpreadsheetBuilder\Activate;
use TrooSpreadsheetBuilder\Database\Setup;
use TrooSpreadsheetBuilder\Controllers\OrdersController;

/**
* 
*/
class Plugin
{
	/**
	* The name of this plugin.
	* 
	* @var string
	*/
	public $name = 'Troo Speadsheet Builder';

	/**
	* The entry point for wordpress to run this plugin.
	*
	* @return void
	*/
	public static function runner()
	{
		$plugin = new Plugin();
		$plugin->init();
	}
	
	/**
	* This initiates the plugin.
	* 
	* @return void
	*/
	private function init()
	{
		// Registers functions to be ran upon activation.
		$this->registerActivationHooks();

		// Registers all the wordpress hooks used.
		$this->registerWordpressHooks();
	}

	/**
	* Registers functions to be ran when plugin is activated.
	*
	* @return void
	*/
	private function registerActivationHooks()
	{
		register_activation_hook(dirname ( __DIR__ , 1 ) . '\wp-troo-spreadsheet-builder.php', array( new Setup, 'run'));
	}

	/**
	* Registers all the wordpress hooks used.
	*
	* @return void
	*/
	private function registerWordpressHooks()
	{
		add_action('admin_menu', array($this,'addPluginToAdminNav'));
	}

	/**
	* Adds a menu option in the admin nav bar for this plugin.
	*
	* @return void
	*/
	public function addPluginToAdminNav()
	{
		add_menu_page(
			'Troo Spread Sheet Builder',
			'Troo Spreadsheet Builder',
			'manage_options',
			$this->name,
			array(new OrdersController(), 'displayPage')
		);
	}
}