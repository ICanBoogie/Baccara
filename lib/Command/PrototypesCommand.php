<?php

namespace ICanBoogie\Baccara\Command;

class PrototypesCommand extends AbstractCommand
{
    public function __invoke(array $args)
    {
    	list($pattern) = $args + [ 0 => null ];

		$config = $this->baccara->app->configs['prototype'];

		if ($pattern) {
			$config = array_filter($config, function ($key) use ($pattern) {

				return fnmatch($pattern, $key);

			}, ARRAY_FILTER_USE_KEY);
		}

		ksort($config);

		foreach ($config as $class => $methods) {
			echo $class . PHP_EOL;

			ksort($methods);

			foreach ($methods as $method => $callbacks) {
				printf(" - %-36s %s\n", $method, implode(':', $callbacks));
			}
		}
    }
}
