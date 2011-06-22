<?php
namespace iter;
require_once 'lib/iterators.php';
require_once 'lib/exceptions.php';

const VERSION = 0.55;

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

	if (!($iterable instanceof \Iterator)){
		throw new exceptions\ArgumentTypeException(
			__FUNCTION__,
			1,
			'string or array or Iterator'
		);
	}

	return new lib\CycleIterator($iterable);
}

function repeat($object, $times=null){
	if ($times !== null && !is_int($times)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 2, 'int or null');
	}

	return new lib\RepeatIterator($object, $times);
}

function chain($_){
	$iterators = array();

	foreach (func_get_args() as $index => $arg){
		if (is_string($arg)){
			$arg = new lib\StringIterator($arg);
		} else if (is_array($arg)){
			$arg = new \ArrayIterator($arg);
		}

		if (!($arg instanceof \Iterator)){
			throw new exceptions\ArgumentTypeException(
				__FUNCTION__,
				$index,
				'string or array or Iterator'
			);
		}

		$iterators[] = $arg;
	}

	return new lib\ChainIterator($iterators);
}

function compress($data, $selectors)
{
	return new lib\CompressIterator(izip($data, $selectors));
}

function izip($_)
{
	$iterators = array();
	foreach (func_get_args() as $index => $arg){
		if (is_string($arg)){
			$arg = new lib\StringIterator($arg);
		} else if (is_array($arg)){
			$arg = new \ArrayIterator($arg);
		}

		if (!($arg instanceof \Iterator)){
			throw new exceptions\ArgumentTypeException(
				__FUNCTION__,
				$index,
				'string or array or Iterator'
			);
		}

		$iterators[] = $arg;
	}

	return new lib\ZipIterator($iterators);
}

function islice($iterable, $_)
{
	if (is_string($iterable)){
		$iterable = new lib\StringIterator($iterable);
	} else if (is_array($iterable)){
		$iterable = new \ArrayIterator($iterable);
	}

	if (!($iterable instanceof \Iterator)){
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

function imap(\Closure $function=null){
	$iterables = array_slice(func_get_args(), 1);
	$args_iterator = call_user_func_array('iter\izip', $iterables);
	return new lib\MapIterator($function, $args_iterator);
}

function starmap($function, $iterables){
	if ($function === null){
		$function = function($x){ return $x;};
	} else if (!($function instanceof \Closure)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 1, 'Closure or null');
	}

	$args_iterator = call_user_func_array('iter\izip', $iterables);

	return new lib\MapIterator($function, $args_iterator);
}

function ifilter($predicate, $iterable)
{
	return _ifilter($predicate, $iterable, true);
}

function ifilterfalse($predicate, $iterable)
{
	return _ifilter($predicate, $iterable, false);
}

function _ifilter($predicate, $iterable, $check)
{
	if ($predicate === null){
		$predicate = function($x){ return $x;};
	} else if (!($predicate instanceof \Closure)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 1, 'Closure or null');
	}

	if (is_string($iterable)){
		$iterable = new lib\StringIterator($iterable);
	} else if (is_array($iterable)){
		$iterable = new \ArrayIterator($iterable);
	}

	if (!($iterable instanceof \Iterator)){
		throw new exceptions\ArgumentTypeException(
			__FUNCTION__,
			2,
			'string or array or Iterator'
		);
	}

	return new lib\FilterIterator($predicate, $iterable, $check);
}
?>