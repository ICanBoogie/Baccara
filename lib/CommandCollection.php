<?php

namespace ICanBoogie\Baccara;

class CommandCollection
{
	/**
	 * @var array
	 */
	private $definitions;

	/**
	 * @param array $commands
	 */
	public function __construct(array $commands)
	{
		$this->attach_many($commands);
	}

	/**
	 * @param string $path
	 * @param string $class_or_command
	 */
	public function attach($path, $class_or_command)
	{
		$this->definitions[$path] = $class_or_command;
	}

	/**
	 * @param array $array
	 */
	public function attach_many(array $array)
	{
		foreach ($array as $path => $class_or_command)
		{
			$this->attach($path, $class_or_command);
		}
	}

	public function find_matches($request)
	{
		$matches = [];
		$request_parts_number = count($request);

		foreach ($this->definitions as $path => $class_or_command)
		{
			$path_parts = explode(' ', $path);
			$path_parts_number = count($path_parts);

			if ($request_parts_number < $path_parts_number)
			{
				continue;
			}

			if (array_slice($request, 0, $path_parts_number) !== $path_parts)
			{
				continue;
			}

			$matches[$path] = [ $class_or_command, array_slice($request, $path_parts_number) ];
		}

		return $matches;
	}
}
