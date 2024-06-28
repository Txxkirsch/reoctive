<?php

namespace App\Test\TestCase\Queue\Task;

use Cake\TestSuite\TestCase;
use App\Queue\Task\SetEmailAndPushTask;
use Cake\Core\Configure;

class SetEmailAndPushTaskTest extends TestCase
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
	// public function testRun(): void
	// {
	// 	$task = new SetEmailAndPushTask();

	// 	//TODO
	// 	//$task->run($data, $jobId);
	// }
}
