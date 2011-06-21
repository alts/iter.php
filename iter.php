<?php
namespace iter;
require_once 'lib/iterators.php';
require_once 'lib/exceptions.php';

const VERSION = 0.35;

function count($start=0, $step=1)
{
	if (!is_int($start)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 1, 'int');
	} else if (!is_int($step)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 2, 'int');
	}

	return new lib\CountIterator($start, $step);
}

function cycle($iterable)
{
	if (is_string($iterable)){
		$iterable = new lib\StringIterator($iterable);
	}

	if (is_array($iterable)){
		$iterable = new \IteratorIterator($iterable);
	}

	if (_is_iterator($iterable)){
		return new lib\CycleIterator($iterable);
	}

	throw new exceptions\ArgumentTypeException(
		__FUNCTION__,
		1,
		'string or array or Iterator'
	);
}

function repeat($object, $times=null){
	if ($times !== null && !is_int($times)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 2, 'int or null');
	}

	return new lib\RepeatIterator($object, $times);
}

function chain($_){
	$iterables = array();

	foreach (func_get_args() as $index => $arg){
		if (is_string($arg)){
			$arg = new lib\StringIterator($arg);
		} else if (is_array($arg)){
			$arg = new \ArrayIterator($arg);
		}

		if (!_is_iterator($arg)){
			throw new exceptions\ArgumentTypeException(
				__FUNCTION__,
				$index,
				'string or array or Iterator'
			);
		}

		$iterables[] = $arg;
	}

	return new lib\ChainIterator($iterables);
}

function compress($data, array $selectors)
{
	if (is_string($data)){
		$data = new lib\StringIterator($data);
	} else if (is_array($data)) {
		$data = new \ArrayIterator($data);
	}

	if (!_is_iterator($data)){
		throw new exceptions\ArgumentTypeException(
			__FUNCTION__,
			1,
			'string or array or Iterator'
		);
	}

	return new lib\CompressIterator($data, new \ArrayIterator($selectors));
}

function izip($_)
{
	foreach (func_get_args() as $index => $arg){
		if (is_string($arg)){
			$arg = new lib\StringIterator($arg);
		} else if (is_array($arg)){
			$arg = new \ArrayIterator($arg);
		}

		if (!_is_iterator($arg)){
			throw new exceptions\ArgumentTypeException(
				__FUNCTION__,
				$index,
				'string or array or Iterator'
			);
		}

		$iterables[] = $arg;
	}

	return new lib\ZipIterator($iterables);
}

function islice($iterable, $_)
{
	if (is_string($iterable)){
		$iterable = new lib\StringIterator($iterable);
	} else if (is_array($iterable)){
		$iterable = new \ArrayIterator($iterable);
	}

	if (!_is_iterator($iterable)){
		throw new exceptions\ArgumentTypeException(
			__FUNCTION__,
			1,
			'string or array or Iterator'
		);
	}

	$start = 0;
	$stop = null;
	$step = 1;
	$args = array_slice(func_get_args(), 1);
	$count_args = \count($args);
	$start_index = 1;
	$stop_index = 2;
	$step_index = 3;

	if ($count_args === 1){
		$stop = $args[0];
		$stop_index--;
	} else if ($count_args === 2){
		list($start, $stop) = $args;
	} else {
		list($start, $stop, $step) = array_slice($args, 0, 3);
	}

	$iterator = izip(
		array($start, $stop, $step),
		array($start_index, $stop_index, $step_index)
	);

	foreach ($iterator as $index => $values){
		if ((!is_int($values[0]) || $values[0] < 0) && ($index !== 1 || $values[0] !== null)){
			throw new exceptions\ArgumentTypeException(__FUNCTION__, $values[1], 'int');
		}
	}

	return new lib\SliceIterator($iterable, $start, $stop, $step);
}

function _is_iterator($iterable){
	if (is_object($iterable)){
		$reflection = new \ReflectionClass('Iterator');
		return $reflection->isInstance($iterable);
	}
	return false;
}
?>