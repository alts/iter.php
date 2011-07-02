<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class WhileTest extends PHPUnit_Framework_TestCase
{
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
		foreach (iter\dropWhile($predicate, $sample) as $item){
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
		foreach ($iterator as $index => $item){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $item);
		}
		$this->assertEquals(1, $iterations);

		// test rewind
		$iterations = 0;
		foreach ($iterator as $index => $item){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $item);
		}
		$this->assertEquals(1, $iterations);
	}
}
?>