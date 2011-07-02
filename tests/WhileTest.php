<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class WhileTest extends PHPUnit_Framework_TestCase
{
	// dropwhile

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testDropWhileNotIterable()
	{
		iter\dropWhile(function($x){return true;}, true);
	}

	public function testDropWhileNoQualify()
	{
		$predicate = function ($x){
			return $x > 5;
		};
		$sample = array(1,2,3,4);
		foreach (iter\dropWhile($predicate, $sample) as $value){
			$this->fail('This iterator should be empty');
		}
	}

	public function testDropWhileSomeQualify()
	{
		$predicate = function ($x){
			return $x > 5;
		};
		$sample = array(1,2,3,4,5,6);
		$iterator = iter\dropWhile($predicate, $sample);
		$expected = array(6);

		$iterations = 0;
		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(1, $iterations);

		// test rewind
		$iterations = 0;
		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(1, $iterations);
	}

	// takewhile

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testTakeWhileNotIterable()
	{
		iter\takeWhile(function($x){return true;}, true);
	}

	public function testTakeWhileNoQualify()
	{
		$predicate = function ($x){
			return $x > 5;
		};
		$sample = array(1,2,3,4);
		foreach (iter\dropWhile($predicate, $sample) as $value){
			$this->fail('This iterator should be empty');
		}
	}

	public function testTakeWhileSomeQualify()
	{
		$predicate = function ($x){
			return $x < 5;
		};
		$sample = array(1,2,3,4,5,6);
		$iterator = iter\takeWhile($predicate, $sample);
		$expected = array(1,2,3,4);

		$iterations = 0;
		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(4, $iterations);

		// test rewind
		$iterations = 0;
		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}
		$this->assertEquals(4, $iterations);
	}
}
?>