<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class StringTest extends PHPUnit_Framework_TestCase
{
	public function testStringIterator()
	{
		$string = 'Hello123!';
		$str_iter = new iter\lib\StringIterator($string);
		// test iteration
		foreach ($str_iter as $index => $char){
			$this->assertEquals($string[$index], $char);
		}

		$this->assertEquals(strlen($string) - 1, $index);

		// test rewind
		foreach ($str_iter as $index => $char){
			$this->assertEquals($string[$index], $char);
		}

		$this->assertEquals(strlen($string) - 1, $index);
	}
}
?>