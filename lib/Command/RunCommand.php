<?php

namespace ICanBoogie\Baccara\Command;

class RunCommand extends AbstractCommand
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $arguments)
	{
		$dir = getcwd();
		$public = $dir . DIRECTORY_SEPARATOR . 'web';

		chdir($public);

		$host = 'localhost';
		$start = 8000;
		$end = 8100;

		$port = $this->find_available_port($host, $start, $end);

		if (!$port)
		{
			throw new \Exception("Unable to find an available port");
		}

		echo "ICanBoogie development server started on http://localhost:$port/\n";

		system("php -S localhost:$port index.php");
	}

	/**
	 * @param string $host
	 * @param int $start
	 * @param int $end
	 *
	 * @return int|null
	 */
	private function find_available_port($host, $start, $end)
	{
		for ($port = $start ; $port < $end + 1 ; $port++)
		{
			$connection = @fsockopen($host, $port);

			if (is_resource($connection))
			{
				fclose($connection);

				continue;
			}

			return $port;
		}

		return null;
	}
}
