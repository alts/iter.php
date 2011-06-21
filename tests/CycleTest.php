<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class CycleTest extends PHPUnit_Framework_TestCase
{
	public function testCycle()
	{
		$iterable = 'Help!';
		$iterations = 0;
		$max_iterations = strlen($iterable) * 2 + 1;

		foreach (iter\cycle($iterable) as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($iterable[$iterations % strlen($iterable)], $value);
			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}

	public function testCycleRewind()
	{
		$iterable = 'Help!';
		$max_iterations = strlen($iterable) * 2 + 1;
		$iterations = 0;

		$iterator = iter\cycle($iterable);

		foreach ($iterator as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($iterable[$iterations % strlen($iterable)], $value);
			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);

		$iterations = 0;

		foreach ($iterator as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($iterable[$iterations % strlen($iterable)], $value);
			if (++$iterations == $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}
}
?>