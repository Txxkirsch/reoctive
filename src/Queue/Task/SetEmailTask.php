<?php

namespace App\Queue\Task;

use App\Provider\ReolinkProvider;
use Queue\Queue\AddInterface;
use Queue\Queue\Task;

class SetEmailTask extends Task implements AddInterface
{

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void
	{
		$data = [
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

		$provider = new ReolinkProvider('CamFlur');

		$provider->sendRequest('SetEmailV20', $data);
	}

	public function add(?string $data): void
	{
	}
}
