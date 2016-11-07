<?php

namespace ICanBoogie\Baccara\Command;

use ICanBoogie\Baccara\Command;

abstract class AbstractCommand implements Command
{
	protected $baccara;

	public function __construct($baccara)
	{
		$this->baccara = $baccara;
	}

	public function matches(array $args)
	{
		return true;
	}
}
