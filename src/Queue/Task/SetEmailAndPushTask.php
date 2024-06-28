<?php

namespace App\Queue\Task;

use Queue\Queue\Task;
use App\Provider\ReolinkProvider;

class SetEmailAndPushTask extends Task
{

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void
	{
		$deviceDataEmail = $this->getEmailData($data);

		$deviceDataPush = $this->getPushData($data);

		foreach ($data['deviceNames'] ?? [] as $deviceName) {
			$provider = new ReolinkProvider($deviceName);
			$provider->sendRequest('SetEmailV20', $deviceDataEmail);
			$provider->sendRequest('SetPushV20', $deviceDataPush);
		}
	}

	protected function getEmailData(array $data): array
	{
		return [
			'Email' => [
				'enable'   => (int)(bool)$data['enable'],
				// 'schedule' => [
				// 	'channel' => 0,
				// 	'table'   => [
				// 		'MD' => str_repeat((string)(bool)$data['enable'], 7 * 24),
				// 		// 'AI_DOG_CAT' => str_repeat((string)$data['enable'], 7 * 24),
				// 		// 'AI_PEOPLE' => str_repeat((string)$data['enable'], 7 * 24),
				// 		// 'AI_VEHICLE' => str_repeat((string)$data['enable'], 7 * 24),
				// 	],
				// ],
			],
		];
	}

	protected function getPushData(array $data): array
	{
		return [
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
	}
}
