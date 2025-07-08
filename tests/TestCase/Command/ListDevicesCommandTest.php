<?php

declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\ListDevicesCommand;
use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

/**
 * App\Command\ListDevicesCommand Test Case
 *
 * @uses \App\Command\ListDevicesCommand
 */
class ListDevicesCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Test buildOptionParser method
     *
     * @return void
     * @uses \App\Command\ListDevicesCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $command = new ListDevicesCommand();
        $parser = new ConsoleOptionParser('list_devices');
        $result = $command->buildOptionParser($parser);
        $this->assertInstanceOf(ConsoleOptionParser::class, $result);
        $options = $result->options();
        $this->assertArrayHasKey('with-passwords', $options);
    }

    /**
     * Test execute method with no devices
     *
     * @return void
     * @uses \App\Command\ListDevicesCommand::execute()
     */
    public function testExecuteNoDevices(): void
    {
        Configure::write('Devices.file', CONFIG . 'devices_test.json');
        $devicesFile = Configure::read('Devices.file');
        file_put_contents($devicesFile, '{}');

        $this->exec('list_devices');
        $this->assertExitSuccess();
        $this->assertErrorContains('No devices configured');

        unlink($devicesFile);
    }

    /**
     * Test execute method with devices
     *
     * @return void
     */
    public function testExecuteWithDevices(): void
    {
        Configure::write('Devices.file', CONFIG . 'devices_test.json');
        $devicesFile = Configure::read('Devices.file');
        $devices = [
            'router1' => [
                'host' => '192.168.1.1',
                'user' => 'admin',
                'pass' => 'secret',
            ],
            'router2' => [
                'host' => '192.168.1.2',
                'user' => 'user',
                'pass' => 'pass123',
            ],
        ];
        file_put_contents($devicesFile, json_encode($devices, JSON_PRETTY_PRINT));

        $this->exec('list_devices');
        $this->assertExitSuccess();
        $this->assertOutputContains('Configured devices:');
        $this->assertOutputContains('1: router1 - 192.168.1.1');
        $this->assertOutputContains('2: router2 - 192.168.1.2');

        unlink($devicesFile);
    }

    /**
     * Test execute method with devices and --with-passwords option
     *
     * @return void
     */
    public function testExecuteWithDevicesAndPasswords(): void
    {
        Configure::write('Devices.file', CONFIG . 'devices_test.json');
        $devicesFile = Configure::read('Devices.file');
        $devices = [
            'router1' => [
                'host' => '192.168.1.1',
                'user' => 'admin',
                'pass' => 'secret',
            ]
        ];
        file_put_contents($devicesFile, json_encode($devices, JSON_PRETTY_PRINT));

        $this->exec('list_devices --with-passwords -v');
        $this->assertExitSuccess();
        $this->assertOutputContains('Configured devices:');
        $this->assertOutputContains('1: router1 - 192.168.1.1');
        $this->assertOutputContains('- User: admin');
        $this->assertOutputContains('- Password: secret');

        unlink($devicesFile);
    }
}
