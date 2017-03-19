<?php

namespace ICanBoogie\Baccara\Command;

use ICanBoogie\Baccara\Baccara;
use ICanBoogie\Baccara\Command;

abstract class AbstractCommand implements Command
{
	/**
	 * @var Baccara
	 */
	protected $baccara;

	/**
	 * @param Baccara $baccara
	 */
	public function __construct(Baccara $baccara)
	{
		$this->baccara = $baccara;
	}

	public function matches(array $args)
	{
		return true;
	}
}
