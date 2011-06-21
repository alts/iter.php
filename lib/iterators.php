<?php
namespace iter\lib;

class StringIterator implements \Iterator
{
	protected $_string;
	protected $_index;

	public function __construct($string)
	{
		$this->_string = $string;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_index = 0;
	}

	public function current()
	{
		return $this->_string[$this->_index];
	}

	public function key()
	{
		return $this->_index;
	}

	public function next()
	{
		$this->_index++;
	}

	public function valid()
	{
		return isset($this->_string[$this->_index]);
	}
}

class CountIterator implements \Iterator
{
	protected $_start;
	protected $_value;
	protected $_step;
	protected $_steps;

	public function __construct($start, $step)
	{
		$this->_start = $start;
		$this->_step = $step;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_value = $this->_start;
		$this->_steps = 0;
	}

	public function current()
	{
		return $this->_value;
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


class RepeatIterator implements \Iterator
{
	protected $_index;
	protected $_object;
	protected $_times;

	public function __construct($object, $times)
	{
		$this->_object = $object;
		$this->_times = $times;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_index = 0;
	}

	public function current()
	{
		return $this->_object;
	}

	public function key()
	{
		return $this->_index;
	}

	public function next()
	{
		$this->_index++;
	}

	public function valid()
	{
		return $this->_times === null || $this->_index < $this->_times;
	}
}


class ChainIterator implements \Iterator
{
	protected $_index;
	protected $_inner_index;

	public function __construct($iterators)
	{
		$this->_iterators = $iterators;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_index = 0;
		$this->_inner_index = 0;
		foreach ($this->_iterators as $iterator){
			$iterator->rewind();
		}
	}

	public function current()
	{
		return $this->_iterators[$this->_inner_index]->current();
	}

	public function key()
	{
		return $this->_index;
	}

	public function next()
	{
		$iterator_count = count($this->_iterators);
		$this->_index++;
		$this->_iterators[$this->_inner_index]->next();

		while ($this->_inner_index < $iterator_count - 1){
			if ($this->valid()){
				break;
			}

			$this->_inner_index++;
		}
	}

	public function valid()
	{
		return $this->_iterators[$this->_inner_index]->valid();
	}
}
?>