<?php

namespace App\Test\TestCase\Queue\Task;

use Cake\TestSuite\TestCase;
use App\Queue\Task\SetPushTask;

class SetPushTaskTest extends TestCase
{

	/**
	 * @var list<string>
	 */
	protected array $fixtures = [
		'plugin.Queue.QueuedJobs',
		'plugin.Queue.QueueProcesses',
	];

	/**
	 * @return void
	 */
	public function testRun(): void
	{
		$task = new SetPushTask();

		//TODO
		$this->assertEmpty(
			$task->run([
				'enable' => 1,
				'deviceNames' => [],
			], 11)
		);
	}
}
