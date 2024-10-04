<?php

namespace App\Test\TestCase\Queue\Task;

use Cake\TestSuite\TestCase;
use App\Queue\Task\SetWhiteLedTask;

class SetWhiteLedTaskTest extends TestCase
{

	/**
	 * @var list<string>
	 */
	protected array $fixtures = [
		'plugin.Queue.QueuedJobs',
		'app.QueuedJobs',
		// 'plugin.Queue.QueueProcesses',
	];

	/**
	 * @return void
	 */
	public function testRun(): void
	{
		$task = new SetWhiteLedTask();

		//TODO
		$this->assertEmpty(
			$task->run([
				'enable' => 1,
				'deviceNames' => [
					// 'CamFlur'
				],
			], 11)
		);
	}

	public function testRunOff(): void
	{
		$task = new SetWhiteLedTask();
		// sleep(2);

		$this->assertEmpty(
			$task->run([
				'enable' => 0,
				'deviceNames' => [
					// 'CamFlur'
				],
			], 12)
		);
	}
}
