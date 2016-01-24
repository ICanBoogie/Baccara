<?php

namespace ICanBoogie\Baccara;

interface Command
{
	/**
	 * @param array $arguments
	 */
	public function __invoke(array $arguments);
}
