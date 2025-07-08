<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

/**
 * AddDevice command.
 */
class AddDeviceCommand extends Command
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

        $name = $io->ask('Enter the device name');
        $host = $io->ask('Enter the device host/ip');
        $user = $io->ask('Enter the device user');
        $pass = $io->ask('Enter the device password');

        $keepGoing = $io->askChoice('Do you want to save this device?', ['y', 'n'], 'y');

        if ($keepGoing !== 'y') {
            $io->abort('Device not saved');
        }

        $device = [
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
        ];

        $devices = json_decode(
            file_get_contents(Configure::read('Devices.file')) ?: '{}',
            true
        );

        if (isset($devices[$name]) && $io->askChoice('Device already exists, do you want to overwrite it?', ['y', 'n'], 'n') !== 'y') {
            $io->abort('Device already exists');
        }

        $devices[$name] = $device;

        $save = file_put_contents(
            Configure::read('Devices.file'),
            json_encode($devices, JSON_PRETTY_PRINT)
        );

        if (!$save) {
            $io->abort('Error saving device');
        }

        $io->success('Device saved');

        return static::CODE_SUCCESS;
    }
}
