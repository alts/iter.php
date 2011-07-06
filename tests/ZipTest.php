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

	public function testEmptyZip()
	{
		foreach (iter\izip() as $value){
			$this->fail('Iterator should be empty');
		}
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

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testBadIterableZipLongest()
	{
		iter\izip_longest(array(1, 2, 3), 7);
	}

	public function testEmptyZipLongest()
	{
		foreach (iter\izip_longest() as $value){
			$this->fail('Iterator should be empty');
		}
	}

	public function testUnevenZipLongest()
	{
		$iterable1 = array(1, 2, 3);
		$iterable2 = 'abcd';
		$iterations = 0;

		foreach (iter\izip_longest('-', $iterable1, $iterable2) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals(isset($iterable1[$index]) ? $iterable1[$index] : '-', $value[0]);
			$this->assertEquals($iterable2[$index], $value[1]);
		}

		$this->assertEquals(4, $iterations);
	}

	public function testZipLongestRewind()
	{
		$iterable1 = array(1, 2, 3);
		$iterable2 = 'abcd';
		$iterations = 0;

		$iterator = iter\izip_longest('-', $iterable1, $iterable2);

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals(isset($iterable1[$index]) ? $iterable1[$index] : '-', $value[0]);
			$this->assertEquals($iterable2[$index], $value[1]);
		}

		$this->assertEquals(4, $iterations);

		$iterations = 0;

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals(isset($iterable1[$index]) ? $iterable1[$index] : '-', $value[0]);
			$this->assertEquals($iterable2[$index], $value[1]);
		}

		$this->assertEquals(4, $iterations);
	}
}