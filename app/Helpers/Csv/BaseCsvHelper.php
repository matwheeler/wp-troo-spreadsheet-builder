<?php

namespace TrooSpreadsheetBuilder\Helpers\Csv;

use TrooSpreadsheetBuilder\Database\Order;

/**
* CSV helper.
*/
class BaseCsvHelper
{
	protected $csv;

	/**
	 * Creates a commer seporated string.
	 * 
	 * @param  object $values
	 * @return string
	 */
	public function createRow($values)
	{
		$row   = "";
		$first = true;
		foreach ($values as $key => $value) {
			$value = $first ? "$value" : ",$value";
			$row   = $row . $value;
			$first = false;
		}
		return $row;
	}

	/**
	 * Adds a row to the csv.
	 * 
	 * @param string $row
	 */
	protected function addRow($row)
	{
		$this->csv = $this->csv . $row;
	}
}