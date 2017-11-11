<?php

namespace TrooSpreadsheetBuilder\Controllers;

use TrooSpreadsheetBuilder\Helpers\Csv\TrooHelper AS TrooCsv;

/**
* Handles requests for the admins orders page.
*/
class OrdersController
{
	public function displayPage()
	{		
		if (isset($_GET["download"])) {
			$this->downloadCsv();
		}
		echo '<h1><a href="' . admin_url("/admin.php?page=" . $_GET["page"] . "&download=1") . '">Download CSV</a><h1>';
	}

	public function downloadCsv()
	{
		// Need to clean otherwise enjoy all the wp html.
		ob_end_clean();

		$csv = new TrooCsv;
		// $csv = $this->generateCsv();

		header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=data.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

		echo $csv->generateTrooOrders();
		exit();
	}

	// public function generateCsv()
	// {
	// 	$csv = "SKU,Size,Color,Quantity,FirstName,LastName,Company,Address1,Address2,City,State,PostCode,Country,ShippingMethod\n";

	// 	// Get orders from db
	// 	$order  = new Order;
	// 	$orders = $order->getForTrooSpreadsheet();

	// 	// validate orders for csv
		

	// 	// enter valid orders into csv
	// 	foreach ($orders as $order) {
	// 		//Create the csv row.
	// 		$row = "$order->sku,,,$order->quantity,$order->first_name,$order->last_name,,$order->address_1,,$order->city,,$order->postcode,$order->country,2nd Class TR\n";

	// 		$csv = $csv . $row;
	// 	}

	// 	// update the troo orders table 
	// 	// update the troo unprossed table
	// 	// update the batches table.

	// 	return $csv;
	// }
}