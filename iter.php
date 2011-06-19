<?php
namespace iter;
require_once 'lib/iterators.php';
require_once 'lib/exceptions.php';

const VERSION = 0.05;

function count($start=0, $step=1)
{
	if (!is_int($start)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 1, 'int');
	} else if (!is_int($step)){
		throw new exceptions\ArgumentTypeException(__FUNCTION__, 2, 'int');
	}

	return new lib\CountIterator($start, $step);
}
?>