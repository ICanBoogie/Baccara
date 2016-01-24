<?php

namespace ICanBoogie\Baccara;

/**
 * @property-read CommandOptionCollection $options
 */
class CommandDefinition
{
	/**
	 * @var CommandOptionCollection
	 */
	private $options;

	/**
	 * @var string|callable
	 */
	public $handler;

	public function __construct()
	{
		$this->options = new CommandOptionCollection;
	}

	public function __get($name)
	{
		if ($name === 'options')
		{
			return $this->options;
		}

		throw new \LogicException("Property not accessible: $name");
	}
}
