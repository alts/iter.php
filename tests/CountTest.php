<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class CountTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testCountBadStart()
	{
		iter\count('BAD', 1);
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testCountBadStep()
	{
		iter\count(1, 'BAD');
	}

	/**
	 * @expectedException iter\exceptions\ArgumentTypeException
	 */
	public function testCountBadStartAndStep()
	{
		iter\count('BAD', 'BAD');
	}

	public function testCountDefaults()
	{
		$iterations = 0;
		$max_iterations = 2;
		$start = 0;
		$step = 1;

		foreach (iter\count() as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}
	}

	public function testCountStart()
	{
		$iterations = 0;
		$max_iterations = 2;
		$start = 7;
		$step = 1;

		foreach (iter\count($start) as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}
	}

	public function testCountStartAndStep()
	{
		$iterations = 0;
		$max_iterations = 2;
		$start = 7;
		$step = 8;

		foreach (iter\count($start, $step) as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}
	}
}
?>