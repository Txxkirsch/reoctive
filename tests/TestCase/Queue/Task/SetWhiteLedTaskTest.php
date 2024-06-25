<?php

namespace App\Test\TestCase\Queue\Task;

use Cake\TestSuite\TestCase;
use App\Queue\Task\SetWhiteLedTask;

class SetWhiteLedTaskTest extends TestCase {

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
	public function testRun(): void {
		$task = new SetWhiteLedTask();

		//TODO
		//$task->run($data, $jobId);
	}

}
