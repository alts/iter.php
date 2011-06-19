<?php
namespace iter;
require_once 'lib/iterators.php';
require_once 'lib/exceptions.php';

const VERSION = 0.15;

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
		$str_array = array();
		for ($i = 0, $l = strlen($iterable); $i < $l; $i++){
			$str_array[] = $iterable[$i];
		}
		$iterable = $str_array;
	}

	if (is_array($iterable)){
		$iterable = new \ArrayIterator($iterable);
	}

	if (is_object($iterable)){
		$reflection = new \ReflectionClass($iterable);
	 	if ($reflection->implementsInterface('Traversable')){
			return new lib\CycleIterator($iterable);
		}
	}

	throw new exceptions\ArgumentTypeException(
		__FUNCTION__,
		1,
		'string or array or object implementing Traversable'
	);
}

function repeat($object, $times=null){
	if ($times !== null && !is_int($times)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 2, 'int or null');
	}

	return new lib\RepeatIterator($object, $times);
}
?>