<?php

namespace ICanBoogie\Baccara\Command;

use ICanBoogie\Baccara\Command\AbstractCommand;

class EventsCommand extends AbstractCommand
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $arguments)
	{
		$app = $this->get_app();
		$events = $app->events;

		foreach ($events as $type => $callbacks)
		{
			echo $type . PHP_EOL;

			foreach ($callbacks as $callback)
			{
				if ($callback instanceof \Closure)
				{
					$reflection = new \ReflectionFunction($callback);

					echo "-- " . $reflection->getFileName() . ':' . $reflection->getStartLine() . PHP_EOL;
				}
				else
				{
					echo "-- " . $callback . PHP_EOL;
				}
			}
		}
	}

	/**
	 * @return \ICanBoogie\Core|\App\Application
	 */
	protected function get_app()
	{
		return $this->baccara->app;
	}
}
