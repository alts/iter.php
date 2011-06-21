<?php
namespace iter;
require_once 'lib/iterators.php';
require_once 'lib/exceptions.php';

const VERSION = 0.30;

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

function _is_iterator($iterable){
	if (is_object($iterable)){
		$reflection = new \ReflectionClass('Iterator');
		return $reflection->isInstance($iterable);
	}
	return false;
}
?>