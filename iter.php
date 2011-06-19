<?php
namespace iter;
require_once 'lib/iterators.php';

const VERSION = 0.05;

function count($start=0, $step=1)
{
	return new lib\CountIterator($start, $step);
}

?>