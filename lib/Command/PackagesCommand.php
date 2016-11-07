<?php

namespace ICanBoogie\Baccara\Command;

class PackagesCommand extends AbstractCommand
{
	public function __invoke(array $arguments)
	{
		$pathname = getcwd() . '/vendor/composer/installed.json';

		if (!file_exists($pathname))
		{
			echo "no file: $pathname\n";

			return;
		}

		$packages = json_decode(file_get_contents($pathname), true);
		$rows = [];

		foreach ($packages as $package)
		{
			$rows[] = [

				$package['name'],
				$package['version'],
				$package['version_normalized'],

			];
		}

		usort($rows, function($v1, $v2) {

			return strcmp($v1[0], $v2[0]);

		});

		$patterns = [];

		for ($i = 0 ; $i < 3 ; $i++)
		{
			$width = array_reduce(array_column($rows, $i), function($carry, $item) {

				return max($carry, strlen($item));

			}, 0);

			$patterns[] = "%-{$width}s";
		}

		$pattern = implode('   ', $patterns) . "\n";

		foreach ($rows as $row)
		{
			echo vsprintf($pattern, $row);
		}
	}
}
