<?php

namespace ICanBoogie\Baccara;

use ICanBoogie\Baccara\Command\Pattern;

class CommandCollection
{
	/**
	 * @var CommandDefinition[]
	 */
	private $definitions;

	/**
	 * @var Baccara
	 */
	private $baccara;

	public function __construct(Baccara $baccara)
	{
		$this->baccara = $baccara;
	}

	/**
	 * @param string $pattern
	 * @param callable $construct
	 */
	public function attach($pattern, callable $construct)
	{
		$definition = new CommandDefinition;
		$construct($definition);

		$this->definitions[$pattern] = $definition;
	}

	public function attach_many(array $array)
	{
		foreach ($array as $pattern => $construct)
		{
			$this->attach($pattern, $construct);
		}
	}

	public function map(array $argv)
	{
		array_shift($argv);

		foreach ($this->definitions as $pattern => $definition)
		{
			$parsed_pattern = Pattern::from($pattern);

			$match = $parsed_pattern->match($argv);

			if ($match)
			{
				list($command, $arguments, $remainder) = $match;

				return $this->execute($definition, $arguments, $remainder);
			}
		}
	}

	protected function execute(CommandDefinition $definition, $arguments, $remainder)
	{
		$handler = $definition->handler;

		if (is_string($handler) && class_exists($handler))
		{
			$handler = new $handler($this->baccara);
		}

		return $handler($arguments);
	}
}
