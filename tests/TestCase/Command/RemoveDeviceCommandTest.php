<?php

declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\RemoveDeviceCommand;
use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

/**
 * App\Command\RemoveDeviceCommand Test Case
 *
 * @uses \App\Command\RemoveDeviceCommand
 */
class RemoveDeviceCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Test buildOptionParser method
     *
     * @return void
     * @uses \App\Command\RemoveDeviceCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $command = new RemoveDeviceCommand();
        $parser = new ConsoleOptionParser('remove_device');
        $result = $command->buildOptionParser($parser);
        $this->assertInstanceOf(ConsoleOptionParser::class, $result);
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\RemoveDeviceCommand::execute()
     */
    public function testExecute(): void
    {
        Configure::write('Devices.file', CONFIG . 'devices_test.json');

        // Setup a temporary devices.json file
        $devicesFile = Configure::read('Devices.file');
        $backup = null;
        if (file_exists($devicesFile)) {
            $backup = file_get_contents($devicesFile);
        }
        $devices = [
            'testDevice' => [
                'host' => '127.0.0.1',
                'user' => 'admin',
                'pass' => 'secret',
            ]
        ];
        file_put_contents($devicesFile, json_encode($devices, JSON_PRETTY_PRINT));

        // Simulate user input to remove the device
        $this->exec('remove_device', array_values([
            'Which device do you want to remove?' => '1',
            'Are you sure you want to remove testDevice?' => 'y',
        ]));

        $this->assertExitSuccess();
        $this->assertOutputContains('Device removed');

        // Clean up
        unlink($devicesFile);
    }
}
