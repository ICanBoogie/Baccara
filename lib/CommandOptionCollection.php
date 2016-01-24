<?php

namespace ICanBoogie\Baccara;

class CommandOptionCollection
{
	private $options = [];
	private $short_names = [];

	public function boolean($name, $short_name)
	{
		$this->short_names[$short_name] = $name;
		$this->options[$name] = 'bool';
	}
}
