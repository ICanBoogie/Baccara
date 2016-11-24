<?php

namespace ICanBoogie\Baccara\Command;

use ICanBoogie\Application\ClearCacheEvent;

class CacheClearCommand extends AbstractCommand
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $arguments)
	{
		$app = $this->baccara->app;

		$event = new ClearCacheEvent($app);

		foreach ($event->used_by as list($hook, $started_at, $finished_at))
		{
			$time = sprintf("%.3f µs", $finished_at - $started_at);

			echo "Invoked: $hook ($time)\n";
		}
	}
}
