<?php

namespace App\Queue\Task;

use App\Provider\ReolinkProvider;
use Cake\Core\Configure;
use Queue\Queue\AddInterface;
use Queue\Queue\Task;

class SetPushTask extends Task implements AddInterface
{

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void
	{
		$data = [
			'Push' => [
				'enable'   => (int)(bool)$data['enable'],
				// 'schedule' => [
				//     'channel' => 0,
				//     'table'   => [
				//         'MD' => str_repeat((string)$data['enable'], 7 * 24),
				//     ],
				// ],
			],
		];

		foreach ($data['deviceNames'] ?? [] as $deviceName) {
			$provider = new ReolinkProvider($deviceName);
			$provider->sendRequest('SetPushV20', $data);
		}
	}

	public function add(?string $data): void
	{
		//todo
	}
}
