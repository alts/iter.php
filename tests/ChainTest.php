<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class ChainTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testChainNotIterable()
	{
		iter\chain(true);
	}

	public function testChainOne()
	{
		$iterable = array(1, 2, 34);
		$iterations = 0;

		// test iteration
		foreach (iter\chain($iterable) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($iterable[$index], $value);
		}

		$this->assertEquals(2, $index);

		// test rewind
		$iterations = 0;
		foreach (iter\chain($iterable) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($iterable[$index], $value);
		}

		$this->assertEquals(2, $index);
	}

	public function testChainSome()
	{
		$iterable1 = array(1, 2, 34);
		$iterable2 = 'yes';

		$iterations = 0;
		$values = array();

		// test iteration
		foreach (iter\chain($iterable1, $iterable2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$values[] = $value;
		}

		$this->assertEquals(array(1, 2, 34, 'y', 'e', 's'), $values);

		// test rewind
		$iterations = 0;
		$values = array();
		foreach (iter\chain($iterable1, $iterable2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$values[] = $value;
		}

		$this->assertEquals(array(1, 2, 34, 'y', 'e', 's'), $values);
	}
}
?>