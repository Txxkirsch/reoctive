<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * RemoveDevice command.
 */
class RemoveDeviceCommand extends Command
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

        $io->success('Configured devices:');

        $i = 1;
        /** @var array<string> $deviceList */
        $deviceList = [];
        foreach ($devices as $name => $device) {
            $io->out("$i: {$name} - {$device['host']}");
            $deviceList[$i] = (string)$name;
            ++$i;
        }

        $deviceIndex = $io->askChoice('Enter the device number to remove', array_keys($deviceList));

        $confirm = $io->askChoice('Are you sure you want to remove this device?', ['y', 'n'], 'n');

        if ($confirm !== 'y') {
            $io->abort('Device not removed');
        }

        unset($devices[$deviceList[$deviceIndex]]);

        $save = file_put_contents(CONFIG . 'devices.json', json_encode($devices, JSON_PRETTY_PRINT));

        if (!$save) {
            $io->abort('Error removing device');
        }

        $io->success('Device removed');

        return static::CODE_SUCCESS;
    }
}
