<?php
namespace iter\exceptions;

class ArgumentTypeException extends \Exception
{
	public function __construct($function, $arg_index, $expected_type)
	{
		parent::__construct(
			"Expected {$expected_type} as argument {$arg_index} to function {$function}"
		);
	}
}
?>