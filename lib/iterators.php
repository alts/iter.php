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
		parent::rewind();
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

class CompressIterator implements \Iterator
{
	protected $_iterable;
	protected $_selectors;
	protected $_index;

	public function __construct($iterable, $selectors)
	{
		$this->_iterable = $iterable;
		$this->_selectors = $selectors;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_index = 0;
		$this->_iterable->rewind();
		$this->_selectors->rewind();
	}

	public function next()
	{
		$this->_index++;
		while ($this->valid()){
			$this->_iterable->next();
			$this->_selectors->next();
			if ($this->_selectors->valid() && $this->_selectors->current()){
				break;
			}
		}
	}

	public function key()
	{
		return $this->_index;
	}

	public function current()
	{
		return $this->_iterable->current();
	}

	public function valid()
	{
		return $this->_iterable->valid() && $this->_selectors->valid();
	}
}

class ZipIterator extends \MultipleIterator
{
	protected $_index;

	public function __construct($iterators)
	{
		$this->_index = 0;
		parent::__construct(\MultipleIterator::MIT_NEED_ALL);
		foreach ($iterators as $iterator){
			$this->attachIterator($iterator);
		}
	}

	public function rewind()
	{
		$this->_index = 0;
		parent::rewind();
	}

	public function next()
	{
		$this->_index++;
		parent::next();
	}

	public function key()
	{
		return $this->_index;
	}
}

class SliceIterator extends \LimitIterator
{
	protected $_step;
	protected $_index;

	public function __construct($iterator, $start, $stop, $step)
	{
		$this->_step = $step;
		parent::__construct($iterator, $start, $stop === null ? -1 : $stop - $start);
		$this->rewind();
	}

	public function rewind()
	{
		$this->_index = 0;
		parent::rewind();
	}

	public function key()
	{
		return $this->_index;
	}

	public function next()
	{
		$this->_index++;
		for ($i = 0; $i < $this->_step; $i++){
			parent::next();
		}
	}
}

class MapIterator implements \Iterator
{
	protected $_function;
	protected $_args_iterator;
	protected $_index;

	public function __construct($function, $args_iterator)
	{
		$this->_function = $function;
		$this->_args_iterator = $args_iterator;
		$this->rewind();
	}

	public function rewind()
	{
		$this->_index = 0;
		$this->_args_iterator->rewind();
	}

	public function next()
	{
		$this->_index++;
		$this->_args_iterator->next();
	}

	public function valid()
	{
		return $this->_args_iterator->valid();
	}

	public function key()
	{
		return $this->_index;
	}

	public function current()
	{
		return $this->_function
			? call_user_func_array($this->_function, $this->_args_iterator->current())
			: $this->_args_iterator->current();
	}
}
?>