<?php
namespace iter\lib;

class CountIterator implements \Iterator
{
	protected $start;
	protected $value;
	protected $step;
	protected $steps;

	public function __construct($start, $step)
	{
		$this->_start = $start;
		$this->_step = $step;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_value = $this->start;
		$this->_steps = 0;
	}

	public function current()
	{
		return $this->value;
	}

	public function key()
	{
		return $this->_steps;
	}

	public function next()
	{
		$this->_value += $this->_step;
		$this->_steps++;
	}

	public function valid()
	{
		return true;
	}
}


class CycleIterator extends \InfiniteIterator
{
	protected $_index;

	public function __construct($iterable)
	{
		$this->_index = 0;
		parent::__construct($iterable);
	}

	public function rewind()
	{
		$this->_index = 0;
	}

	public function key()
	{
		return $this->_index;
	}

	public function next()
	{
		$this->_index++;
		parent::next();
	}

	public function valid()
	{
		if (!parent::valid()){
			parent::rewind();
		}
		return true;
	}
}

?>