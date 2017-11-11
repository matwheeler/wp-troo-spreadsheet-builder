<?php

namespace TrooSpreadsheetBuilder\Database;

/**
*  This is used to set up the relevent tables.
*/
class Order
{
	private $wordpressDB;

	function __construct()
	{
		// Useing the wordpress database connection/functions.
		global $wpdb;
		$this->wordpressDB = $wpdb;
	}

	/**
	 * [getOrders description]
	 * 
	 * @return [type] [description]
	 */
	public function getForTrooSpreadsheet()
	{

		$wooOrdersTable     = $this->wordpressDB->prefix . 'woocommerce_order_items';
		$wooOrdersMetaTable = $this->wordpressDB->prefix . 'woocommerce_order_itemmeta';
		$wpPostMeta         = $this->wordpressDB->prefix . 'postmeta';
		
		// ORDER_ID is the post id of the sale.
		$results = $this->wordpressDB->get_results(
			'SELECT 
			wp_meta1.meta_value AS sku,
			"" AS size,
			"" AS color,
			woo_meta2.meta_value AS quantity,
			wp_meta2.meta_value AS first_name,
			wp_meta3.meta_value AS last_name,
			"" AS company,
			wp_meta4.meta_value AS address_1,
			"" AS address_2,
			wp_meta5.meta_value AS city,
			"" AS state,
			wp_meta6.meta_value AS postcode,
			wp_meta7.meta_value AS country,
			"2nd Class TR" AS shipping_method
			FROM ' . $wooOrdersTable . '

			INNER JOIN ' . $wooOrdersMetaTable . ' as woo_meta1
				ON ' . $wooOrdersTable . '.order_item_id = woo_meta1.order_item_id
				AND woo_meta1.meta_key = "_product_id"
			INNER JOIN ' . $wooOrdersMetaTable . ' as woo_meta2
				ON ' . $wooOrdersTable . '.order_item_id = woo_meta2.order_item_id
				AND woo_meta2.meta_key = "_qty"


			LEFT JOIN ' . $wpPostMeta . ' as wp_meta1
				ON woo_meta1.meta_value = wp_meta1.post_id
				AND wp_meta1.meta_key = "_sku"


			LEFT JOIN ' . $wpPostMeta . ' as wp_meta2
				ON order_id = wp_meta2.post_id
				AND wp_meta2.meta_key = "_shipping_first_name"
			LEFT JOIN ' . $wpPostMeta . ' as wp_meta3
				ON order_id = wp_meta3.post_id
				AND wp_meta3.meta_key = "_shipping_last_name"
			LEFT JOIN ' . $wpPostMeta . ' as wp_meta4
				ON order_id = wp_meta4.post_id
				AND wp_meta4.meta_key = "_shipping_address_1"
			LEFT JOIN ' . $wpPostMeta . ' as wp_meta5
				ON order_id = wp_meta5.post_id
				AND wp_meta5.meta_key = "_shipping_city"
			LEFT JOIN ' . $wpPostMeta . ' as wp_meta6
				ON order_id = wp_meta6.post_id
				AND wp_meta6.meta_key = "_shipping_postcode"
			LEFT JOIN ' . $wpPostMeta . ' as wp_meta7
				ON order_id = wp_meta7.post_id
				AND wp_meta7.meta_key = "_shipping_country"'
		);

		return $results;
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
}