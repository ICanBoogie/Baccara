<?php

namespace ICanBoogie\Baccara\Command;

use ICanBoogie\Baccara\CommandAbstract;
use ICanBoogie\Core\ClearCacheEvent;

class CacheClearCommand extends CommandAbstract
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $arguments)
	{
		$app = $this->baccara->app;

		$event = new ClearCacheEvent($app);

		foreach ($event->used_by as $hooks)
		{
			echo "Event hook invoked: $hooks\n";
		}
	}
}
