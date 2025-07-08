<?php

declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\AddDeviceCommand;
use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Console\ConsoleIo;
use Cake\Console\Arguments;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

/**
 * App\Command\AddDeviceCommand Test Case
 *
 * @uses \App\Command\AddDeviceCommand
 */
class AddDeviceCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Test buildOptionParser method
     *
     * @return void
     * @uses \App\Command\AddDeviceCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $command = new AddDeviceCommand();
        $parser = new ConsoleOptionParser('add_device');
        $result = $command->buildOptionParser($parser);
        $this->assertInstanceOf(ConsoleOptionParser::class, $result);
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\AddDeviceCommand::execute()
     */
    public function testExecute(): void
    {
        Configure::write('Devices.file', CONFIG . 'devices_test.json');

        // Setup a temporary devices.json file
        $devicesFile = Configure::read('Devices.file');
        file_put_contents($devicesFile, '{}');

        $this->exec('add_device', array_values([
            'Enter the device name' => 'testDevice',
            'Enter the device host/ip' => '127.0.0.1',
            'Enter the device user' => 'admin',
            'Enter the device password' => 'secret',
            'Do you want to save this device?' => 'y',
        ]));

        $this->assertExitSuccess();
        $this->assertOutputContains('Device saved');

        // Clean up
        unlink($devicesFile);
    }
}
