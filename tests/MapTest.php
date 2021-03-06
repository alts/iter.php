<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class MapTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNonIterator()
	{
		iter\imap(function($x){ return $x;}, true);
	}

	public function testNoFunction()
	{
		$expected = array(
			array(2, 'x'),
			array(3, 'y'),
			array(5, 'z'),
		);
		$iterable1 = array(2, 3, 5);
		$iterable2 = 'xyz';

		$iterations = 0;

		foreach (iter\imap(null, $iterable1, $iterable2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(3, $iterations);
	}

	public function testUnevenIterables()
	{
		$expected = array(2, 4, 6);
		$iterable1 = array(1, 2, 3);
		$iterable2 = iter\repeat(2);

		$iterations = 0;

		$iterator = iter\imap(
			function($x, $y){ return $x*$y;},
			$iterable1,
			$iterable2
		);

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(3, $iterations);
	}

	public function testRewind()
	{
		$expected = array(2, 4, 6);
		$iterable1 = array(1, 2, 3);
		$iterable2 = iter\repeat(2);

		$iterations = 0;

		$iterator = iter\imap(
			function($x, $y){ return $x*$y;},
			$iterable1,
			$iterable2
		);

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

	public function testStarmap()
	{
		$iterable1 = array(1, 2, 3);
		$iterable2 = array(4, 5, 6);
		$func = function ($x, $y){
			return $x * $y;
		};

		$iterations = 0;

		$iterator = iter\izip(
			iter\imap($func, $iterable1, $iterable2),
			iter\starmap($func, array($iterable1, $iterable2))
		);

		foreach ($iterator as $index => $values){
			$this->assertEquals($iterations++, $index);
			list($map_val, $starmap_val) = $values;
			$this->assertEquals($map_val, $starmap_val);
		}

		$this->assertEquals(3, $iterations);
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testStarmapBadFunc()
	{
		iter\starmap(true, array(1,2,3));
	}
}
?>