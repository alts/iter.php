<?php
namespace iter\lib;

class CountIterator implements \Iterator
{
	private $start;
	private $value;
	private $step;
	private $steps;

	public function __construct($start, $step)
	{
		$this->start = $start;
		$this->step = $step;
		$this->rewind();
	}

	public function rewind()
	{
		$this->value = $this->start;
		$this->steps = 0;
	}

	public function current()
	{
		return $this->value;
	}

	public function key()
	{
		return $this->steps;
	}

	public function next()
	{
		$this->value += $this->step;
		$this->steps++;
	}

	public function valid()
	{
		return true;
	}
}

?>