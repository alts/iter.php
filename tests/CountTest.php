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

		foreach (iter\count() as $index => $value){
			$this->assertEquals($iterations, $index);
			$this->assertEquals($index, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}

	public function testCountStart()
	{
		$iterations = 0;
		$max_iterations = 2;
		$start = 7;
		$step = 1;

		foreach (iter\count($start) as $index => $value){
			$this->assertEquals($iterations, $index);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}

	public function testCountStartAndStep()
	{
		$iterations = 0;
		$max_iterations = 2;
		$start = 7;
		$step = 8;

		foreach (iter\count($start, $step) as $index => $value){
			$this->assertEquals($iterations, $index);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}

	public function testCountRewind()
	{
		$iterations = 0;
		$max_iterations = 2;
		$start = 7;
		$step = 1;

		$iterator = iter\count($start);

		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations, $index);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);

		$iterations = 0;
		foreach ($iterator as $index => $value){
			$this->assertEquals($iterations, $index);
			$this->assertEquals($start + $step * $iterations, $value);

			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}
}
?>