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

	/**
	 * @var \ICanBoogie\Core
	 */
	private $app;

	protected function get_app()
	{
		return $this->app
			?: $this->app = $this->create_app();
	}

	/**
	 * @var string
	 */
	public $root;

	/**
	 * @param $commands
	 */
	public function __construct($commands)
	{
		$this->commands = new CommandCollection($commands);
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

	/**
	 * @param array $argv
	 */
	public function __invoke(array $argv)
	{
		$matches = $this->commands->find_matches($argv);

		foreach ($matches as $path => list($class_or_command, $args))
		{
			$command = $class_or_command;

			if (!$command instanceof Command)
			{
				$command = new $class_or_command($this);
			}

			if (!$command->matches($args))
			{
				continue;
			}

			$command($args);
		}
	}

	/**
	 * Whether a getter is defined for the specific property.
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
		$root = $this->root;
		$pathname = $this->find_path([

			"$root/app/baccara-bootstrap.php",
			"$root/baccara-bootstrap.php",
			"$root/app/bootstrap.php",
			"$root/bootstrap.php"

		]);

		return require_once $pathname;
	}

	private function find_path(array $possible)
	{
		foreach ($possible as $path)
		{
			if (file_exists($path))
			{
				return $path;
			}
		}

		throw new \Exception("Unable to find path, tried:\n", '- ' . implode("\n- ", $possible) . "\n");
	}
}
