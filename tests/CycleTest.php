<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class CycleTest extends PHPUnit_Framework_TestCase
{
	public function testCycleString()
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
	}

	public function testCycleArray()
	{
		$iterable = array(1, 2);
		$iterations = 0;
		$max_iterations = count($iterable) * 2 + 1;

		foreach (iter\cycle($iterable) as $key => $value){
			$this->assertEquals($iterations, $key);
			$this->assertEquals($iterable[$iterations % count($iterable)], $value);
			if (++$iterations == $max_iterations){
				break;
			}
		}
	}
}
?>