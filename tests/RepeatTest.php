<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class RepeatTest extends PHPUnit_Framework_TestCase
{
	public function testRepeatNone()
	{
		foreach (iter\repeat(true, 0) as $key => $value){
			$this->fail('Should not iterate over item repeated zero times');
		}
	}

	public function testRepeatSome()
	{
		$object = array('key' => 1234, 'key2' => null);
		$iterations = 0;
		$times = 5;

		foreach (iter\repeat($object, $times) as $key => $value){
			$this->assertEquals($iterations++, $key);
			$this->assertEquals($object, $value);
		}

		$this->assertEquals($times, $iterations);
	}

	public function testRepeatInfinite()
	{
		$object = array('key' => 1234, 'key2' => null);
		$iterations = 0;
		$max_iterations = 7;

		foreach (iter\repeat($object) as $key => $value){
			$this->assertEquals($iterations++, $key);
			$this->assertEquals($object, $value);
			if ($iterations === $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}

	public function testRepeatRewind()
	{
		$object = array('key' => 1234, 'key2' => null);
		$iterations = 0;
		$max_iterations = 7;

		foreach (iter\repeat($object) as $key => $_){
			$this->assertEquals($iterations++, $key);
			if ($iterations === $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);

		$iterations = 0;

		foreach (iter\repeat($object) as $key => $_){
			$this->assertEquals($iterations++, $key);
			if ($iterations === $max_iterations){
				break;
			}
		}

		$this->assertEquals($max_iterations, $iterations);
	}
}
?>