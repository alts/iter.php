<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class SliceTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNonIntStop()
	{
		iter\islice(array(1, 2, 3), 1, 'b', 1);
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNegativeStop()
	{
		iter\islice(array(1, 2, 3), 1, -1, 1);
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNonIntStart()
	{
		iter\islice(array(1, 2, 3), 'b', 1, 1);
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNegativeStart()
	{
		iter\islice(array(1, 2, 3), -1, 1, 1);
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNonIntStep()
	{
		iter\islice(array(1, 2, 3), 1, 1, 'b');
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testNegativeStep()
	{
		iter\islice(array(1, 2, 3), 1, 1, -1);
	}

	public function testStop()
	{
		$expected = array('A', 'B');
		$iterable = 'ABCDEFG';
		$iterations = 0;

		foreach (iter\islice($iterable, 2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(2, $iterations);
	}

	public function testStartAndStop()
	{
		$expected = array('C', 'D');
		$iterable = 'ABCDEFG';
		$iterations = 0;

		foreach (iter\islice($iterable, 2, 4) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(2, $iterations);
	}

	public function testStartAndNoStop()
	{
		$expected = array('C', 'D', 'E', 'F', 'G');
		$iterable = 'ABCDEFG';
		$iterations = 0;

		foreach (iter\islice($iterable, 2, null) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(5, $iterations);
	}

	public function testStartAndNoStopAndStep()
	{
		$expected = array('A', 'C', 'E', 'G');
		$iterable = 'ABCDEFG';
		$iterations = 0;

		foreach (iter\islice($iterable, 0, null, 2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(4, $iterations);
	}

	public function testStartAndStopAndStep()
	{
		$expected = array('A', 'C', 'E');
		$iterable = 'ABCDEFG';
		$iterations = 0;

		foreach (iter\islice($iterable, 0, 5, 2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(3, $iterations);
	}
}
?>