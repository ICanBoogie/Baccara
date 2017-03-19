<?php

namespace ICanBoogie\Baccara\Command;

class EventsCommand extends AbstractCommand
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $args)
	{
		list($pattern) = $args;

		$events = iterator_to_array($this->baccara->app->events);

		if ($pattern) {
			$events = array_filter($events, function ($key) use ($pattern) {

				return fnmatch('*' . $pattern . '*', $key);

			}, ARRAY_FILTER_USE_KEY);
		}

		foreach ($events as $type => $hooks)
		{
			echo $type . PHP_EOL;

			foreach ($hooks as $hook)
			{
				echo " - " . $this->resolve_hook($hook) . PHP_EOL;
			}
		}
	}

	/**
	 * @param callable $callback
	 *
	 * @return string
	 */
	private function resolve_hook($callback)
	{
		if ($callback instanceof \Closure)
		{
			$reflection = new \ReflectionFunction($callback);

			return $reflection->getFileName() . ':' . $reflection->getStartLine();
		}

		if (is_array($callback))
		{
			return implode('::', $callback);
		}

		return $callback;
	}
}
