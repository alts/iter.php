<?php
require_once dirname(dirname(__FILE__)). '/iter.php';
class CompressTest extends PHPUnit_Framework_TestCase
{
	public function testCompressEven()
	{
		$expected = array('A','C','E','F');
		$iterations = 0;

		// test iteration
		foreach (iter\compress('ABCDEF', array(1,0,1,0,1,1)) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(3, $index);

		// test rewind
		$iterations = 0;
		foreach (iter\compress('ABCDEF', array(1,0,1,0,1,1)) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(3, $index);
	}

	public function testCompressUneven()
	{
		$expected = array('A','C','E');

		$iterations = 0;
		foreach (iter\compress('ABCDE', array(1,0,1,0,1,1)) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(2, $index);

		$iterations = 0;
		foreach (iter\compress('ABCDEF', array(1,0,1,0,1)) as $index => $value){
			$this->assertEquals($iterations++, $index);
			$this->assertEquals($expected[$index], $value);
		}

		$this->assertEquals(2, $index);
	}
}
?>