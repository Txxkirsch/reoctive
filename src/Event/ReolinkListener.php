<?php

declare(strict_types=1);

namespace App\Event;

use App\Queue\Task\SetEmailAndPushTask;
use App\Queue\Task\SetEmailTask;
use App\Queue\Task\SetPushTask;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;

class ReolinkListener implements EventListenerInterface
{
	use LocatorAwareTrait;

	public function implementedEvents(): array
	{
		return [
			'Reoctive.activate'   => 'activate',
			'Reoctive.deactivate' => 'deactivate',
		];
	}

	public function activate(Event $event, array $requestData, array $options): Event
	{
		/** @var \Queue\Model\Table\QueuedJobsTable $QueuedJobs */
		$QueuedJobs = $this->fetchTable('Queue.QueuedJobs');

		$deviceNames = array_keys(Configure::read('Reolink', []));

		$QueuedJobs->createJob(SetEmailAndPushTask::class, [
			'deviceNames' => $deviceNames,
			'enable' => 1,
		]);

		return $event;
	}

	public function deactivate(Event $event, array $requestData, array $options): Event
	{
		/** @var \Queue\Model\Table\QueuedJobsTable $QueuedJobs */
		$QueuedJobs = $this->fetchTable('Queue.QueuedJobs');

		$deviceNames = array_keys(Configure::read('Reolink', []));

		$QueuedJobs->createJob(SetEmailAndPushTask::class, [
			'deviceNames' => $deviceNames,
			'enable' => 0,
		]);

		return $event;
	}
}
