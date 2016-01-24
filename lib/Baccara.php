<?php

namespace ICanBoogie\Baccara;

/**
 * @property-read \ICanBoogie\Core $app
 * @property-read CommandCollection $commands
 */
class Baccara
{
	/**
	 * @var CommandCollection
	 */
	private $commands;

	protected function get_commands()
	{
		return $this->commands;
	}

	private $app;

	protected function get_app()
	{
		return $this->app
			?: $this->app = $this->create_app();
	}

	public $root;

	public function __construct()
	{
		$this->commands = new CommandCollection($this);
		$this->root = getcwd();
	}

	/**
	 * @inheritdoc
	 *
	 * @throws \LogicException if a property is not accessible.
	 */
	public function __get($name)
	{
		if ($this->has_getter($name))
		{
			return $this->{ 'get_' . $name }();
		}

		throw new \LogicException("Property not accessible: $name");
	}

	public function __invoke(array $argv)
	{

	}

	/**
	 * Whether a getter is defined for the specifiec property.
	 *
	 * @param string $property Property name.
	 *
	 * @return bool
	 */
	protected function has_getter($property)
	{
		return in_array($property, [ 'commands', 'app' ]);
	}

	/**
	 * Creates application.
	 *
	 * @return mixed
	 */
	protected function create_app()
	{
		$pathname = $this->root . DIRECTORY_SEPARATOR . 'baccara-startup.php';

		if (!file_exists($pathname))
		{
			$pathname = $this->root . DIRECTORY_SEPARATOR . 'bootstrap.php';
		}

		if (!file_exists($pathname))
		{
			throw new \LogicException("Unable to create application, file `$pathname` is missing.`");
		}

		return require_once $pathname;
	}
}
