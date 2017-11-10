<?php

namespace TrooSpreadsheetBuilder\Database;

/**
*  This is used to set up the relevent tables.
*/
class Setup
{
	private $wordpressDB;

	function __construct()
	{
		// Useing the wordpress database connection/functions.
		global $wpdb;
		$this->wordpressDB = $wpdb;
	}

	/**
	* Runs all the setup functions for the database.
	*
	* @return void
	*/
	public static function run()
	{
		//Yep, i want to throw up as well.
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// Create all tables.
		$this->createOrdersTable();
		$this->createBatchesTable();
		$this->createUnprocessedTable();
	}

	/**
	* Creates the orders table
	*
	* @return void
	*/
	private function createOrdersTable()
	{
		$tableName      = $this->wordpressDB->prefix . 'troo_orders';
		$charsetCollate = $this->wordpressDB->get_charset_collate();

		$sql = "CREATE TABLE $tableName (
                id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                woocom_order_item_id bigint(20) UNSIGNED NOT NULL,
                woocom_order_id bigint(20) UNSIGNED NOT NULL,
                batch_id int(11) UNSIGNED NOT NULL,
                PRIMARY KEY  (id)
              ) $charsetCollate;";

		// using the worppress sql function to create/update.
        dbDelta($sql);
	}

	/**
	* Creates the batches table
	*
	* @return void
	*/
	private function createBatchesTable()
	{
		$tableName      = $this->wordpressDB->prefix . 'troo_batches';
		$charsetCollate = $this->wordpressDB->get_charset_collate();

		$sql = "CREATE TABLE $tableName (
                id int(1) UNSIGNED NOT NULL AUTO_INCREMENT,
                created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY  (id)
              ) $charsetCollate;";

		// using the worppress sql function to create/update.
        dbDelta($sql);
	}

	/**
	* Creates the unprocessed table
	*
	* @return void
	*/
	private function createUnprocessedTable()
	{
		$tableName      = $this->wordpressDB->prefix . 'troo_unproccessed';
		$charsetCollate = $this->wordpressDB->get_charset_collate();

		$sql = "CREATE TABLE $tableName (
                id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                woocom_order_item_id bigint(20) NOT NULL,
                woocom_order_id bigint(20) NOT NULL,
                PRIMARY KEY  (id)
              ) $charsetCollate;";

		// using the worppress sql function to create/update.
        dbDelta($sql);
	}
}