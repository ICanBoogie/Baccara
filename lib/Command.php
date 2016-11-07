<?php

namespace ICanBoogie\Baccara;

interface Command
{
	public function matches(array $args);

	/**
	 * @param array $arguments
	 */
	public function __invoke(array $arguments);
}
