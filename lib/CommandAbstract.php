<?php

namespace ICanBoogie\Baccara;

use ICanBoogie\Baccara\Command;

abstract class CommandAbstract implements Command
{
	protected $baccara;

	public function __construct($baccara)
	{
		$this->baccara = $baccara;
	}
}
