<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class ZipTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testBadIterable()
	{
		iter\izip(array(1, 2, 3), 7);
	}

	public function testUnevenZip()
	{
		$iterable1 = array(1, 2, 3);
		$iterable2 = 'abcdefg';
		$iterations = 0;

		foreach (iter\izip($iterable1, $iterable2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($iterable1[$index], $value[0]);
			$this->assertEquals($iterable2[$index], $value[1]);
		}

		$this->assertEquals(3, $iterations);
	}

	public function testZipRewind()
	{
		$iterable1 = array(1, 2, 3);
		$iterable2 = 'abcdefg';
		$iterations = 0;

		$iterator = iter\izip($iterable1, $iterable2);

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($iterable1[$index], $value[0]);
			$this->assertEquals($iterable2[$index], $value[1]);
		}

		$this->assertEquals(3, $iterations);

		$iterations = 0;

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($iterable1[$index], $value[0]);
			$this->assertEquals($iterable2[$index], $value[1]);
		}

		$this->assertEquals(3, $iterations);
	}
}