<?php

namespace App\Test\TestCase\Queue\Task;

use Cake\TestSuite\TestCase;
use App\Queue\Task\SetEmailTask;

class SetEmailTaskTest extends TestCase
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
		$task = new SetEmailTask();

		//TODO
		$this->assertEmpty(
			$task->run([
				'enable' => 1,
				'deviceNames' => [],
			], 11)
		);
	}
}
