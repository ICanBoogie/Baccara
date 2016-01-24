<?php

namespace ICanBoogie\Baccara\Command;

class Pattern
{
	const TYPE_COMMAND = 1;
	const TYPE_REQUIRED = 2;
	const TYPE_OPTIONAL = 3;
	const TYPE_SWITCH = 4;

	const PREFIX_REQUIRED = ':';
	const PREFIX_OPTIONAL = '?';
	const PREFIX_SWITCH = '!';

	static public function from($pattern)
	{
		$parts = explode(' ', $pattern);
		$arguments = [];
		$command = [];

		foreach ($parts as $part)
		{
			if (strpos($part, self::PREFIX_REQUIRED) === 0)
			{
				$name = substr($part, 1);
				$arguments[$name] = self::TYPE_REQUIRED;
			}
			elseif (strpos($part, self::PREFIX_OPTIONAL) === 0)
			{
				$name = substr($part, 1);
				$arguments[$name] = self::TYPE_OPTIONAL;
			}
			elseif (strpos($part, self::PREFIX_OPTIONAL) === 0)
			{
				$name = substr($part, 1);
				$arguments[$name] = self::TYPE_SWITCH;
			}
			else
			{
				$command[] = $part;
			}
		}

		return new static($command, $arguments);
	}

	/**
	 * @var array
	 */
	private $command;

	/**
	 * @var array
	 */
	private $arguments;

	/**
	 * Pattern constructor.
	 *
	 * @param array $command
	 * @param array $arguments
	 */
	public function __construct(array $command, array $arguments)
	{
		$this->command = $command;
		$this->arguments = $arguments;
	}

	public function match($argv)
	{
		$command = $this->command;
		$command_count = count($command);

		if (count($argv) < $command_count || array_slice($argv, 0, $command_count) != $command)
		{
			return false;
		}

		$argv = array_slice($argv, $command_count);
		$arguments = array_fill_keys(array_keys($this->arguments), null);

		foreach ($this->arguments as $name => $type)
		{
			if (!$argv)
			{
				if ($type === self::TYPE_REQUIRED)
				{
					throw new \InvalidArgumentException("Missing required argument: $name");
				}

				continue;
			}

			$arg = array_shift($argv);
			$arguments[$name] = $arg;
		}

		return [ $command, $arguments, $argv ];
	}
}
