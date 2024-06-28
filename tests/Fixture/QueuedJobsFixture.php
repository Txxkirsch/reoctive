<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QueuedJobsFixture
 */
class QueuedJobsFixture extends TestFixture
{
	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void
	{
		$this->records = [
			[
				'id' => 11,
				'job_task' => 'SetWhiteLed',
				'data' => json_encode(['deviceNames' => ['CamFlur'], 'enable' => 1]),
				'job_group' => null,
				'reference' => null,
				'created' => '2024-06-28 14:47:02',
				'notbefore' => '2024-06-28 14:47:02',
				'fetched' => null,
				'completed' => null,
				'progress' => 0,
				'attempts' => 0,
				'failure_message' => null,
				'workerkey' => null,
				'status' => null,
				'priority' => 1,
			],

			[
				'id' => 12,
				'job_task' => 'SetWhiteLed',
				'data' => json_encode(['deviceNames' => ['CamFlur'], 'enable' => 0]),
				'job_group' => null,
				'reference' => null,
				'created' => '2024-06-28 14:47:02',
				'notbefore' => '2024-06-28 14:47:02',
				'fetched' => null,
				'completed' => null,
				'progress' => 0,
				'attempts' => 0,
				'failure_message' => null,
				'workerkey' => null,
				'status' => null,
				'priority' => 1,
			],
		];
		parent::init();
	}
}
