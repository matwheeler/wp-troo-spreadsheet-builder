<?php

namespace TrooSpreadsheetBuilder\Helpers\Csv;

use TrooSpreadsheetBuilder\Database\Order;

/**
* CSV helper.
*/
class TrooHelper extends BaseCsvHelper
{

	/**
	 * Creates a csv to troo's specs from the orders.
	 * 
	 * @return string
	 */
	public function generateTrooOrders()
	{
		// Add the header row
		$this->addRow("SKU,Size,Color,Quantity,FirstName,LastName,Company,Address1,Address2,City,State,PostCode,Country,ShippingMethod\n");

		// Add the orders to the csv
		foreach ($this->getValidatedTrooOrders() as $order) {
			//Create the csv row.
			$this->addRow($this->createRow($order) . "\n");
		}

		// update the troo orders table 
		// update the troo unprossed table
		// update the batches table.

		return $this->csv;
	}

	/**
	 * Gets all valid orders ready to be shipped by troo.
	 * 
	 * @return array
	 */
	protected function getValidatedTrooOrders()
	{
		// Get orders from db
		$order  = new Order;
		$orders = $order->getForTrooSpreadsheet();

		// validate the orders


		return $orders;
	}
}