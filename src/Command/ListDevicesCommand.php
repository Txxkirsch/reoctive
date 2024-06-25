<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * ListDevices command.
 */
class ListDevicesCommand extends Command
{
	/**
	 * Hook method for defining this command's option parser.
	 *
	 * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
	 * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
	 * @return \Cake\Console\ConsoleOptionParser The built parser.
	 */
	public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
	{
		$parser = parent::buildOptionParser($parser);

		$parser->addOption('with-passwords', [
			'boolean' => true,
			'default' => false,
			'short' => 'p',
		]);

		return $parser;
	}

	/**
	 * Implement this method with your command's logic.
	 *
	 * @param \Cake\Console\Arguments $args The command arguments.
	 * @param \Cake\Console\ConsoleIo $io The console io
	 * @return int|null|void The exit code or null for success
	 */
	public function execute(Arguments $args, ConsoleIo $io)
	{
		$devices = json_decode(file_get_contents(CONFIG . 'devices.json') ?: '{}', true);

		if (!count($devices)) {
			$io->abort('No devices configured', static::CODE_SUCCESS);
		}

		$io->out('Configured devices:');

		$i = 1;
		$deviceList = [];
		foreach ($devices as $name => $device) {
			$io->out("$i: {$name} - {$device['host']}");
			$io->verbose(' - User: ' . $device['user']);
			if ($args->getBooleanOption('with-passwords')) {
				$io->verbose(' - Password: ' . $device['pass']);
			}
		}
	}
}
