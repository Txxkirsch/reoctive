<?php

namespace App\Queue\Task;

use App\Provider\ReolinkProvider;
use Cake\Core\Configure;
use Queue\Queue\AddInterface;
use Queue\Queue\Task;

class SetWhiteLedTask extends Task implements AddInterface
{

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void
	{
		$data = [
			'WhiteLed' => [
				'state'   => $data['enable'],
				'channel' => 0,
				// 'bright' => 70,
			],
		];

		foreach ($data['deviceNames'] ?? [] as $deviceName) {
			$provider = new ReolinkProvider($deviceName);
			$provider->sendRequest('SetWhiteLed', $data);
		}
	}

	public function add(?string $data): void
	{
		//todo
	}
}
