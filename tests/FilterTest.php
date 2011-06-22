<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class FilterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNotClosure()
	{
		iter\ifilter(4, array(1,2,3));
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNotIterable()
	{
		iter\ifilter(function($x){ return $x;}, true);
	}

	public function testFilterNull()
	{
		$expected = array(1, 2, 3);
		$iterable = array(0, 1, 2, 3);
		$iterations = 0;
		foreach (iter\ifilter(null, $iterable) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(3, $iterations);
	}

	public function testFilterRewind()
	{
		$expected = array(1, 2, 3);
		$iterable = array(0, 1, 2, 3);
		$iterations = 0;

		$iterator = iter\ifilter(null, $iterable);

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(3, $iterations);

		$iterations = 0;
		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(3, $iterations);
	}

	public function testFilterClosure()
	{
		$expected = array(1, 3);
		$iterable = array(0, 1, 2, 3);
		$iterations = 0;

		foreach (iter\ifilter(function($x){ return $x % 2;}, $iterable) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(2, $iterations);
	}

	public function testFilterFalse()
	{
		$expected = array(0, 2);
		$iterable = array(0, 1, 2, 3);
		$iterations = 0;

		foreach (iter\ifilterfalse(function($x){ return $x % 2;}, $iterable) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(2, $iterations);
	}
}
?>