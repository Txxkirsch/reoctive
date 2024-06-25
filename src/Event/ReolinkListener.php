<?php
declare (strict_types = 1);

namespace App\Event;

use App\Queue\Task\SetEmailTask;
use App\Queue\Task\SetPushTask;
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
        $QueuedJobs = $this->fetchTable('Queue.QueuedJobs');

        $QueuedJobs->createJob(SetEmailTask::class, [
            'enable' => 1,
        ]);

        $QueuedJobs->createJob(SetPushTask::class, [
            'enable' => 1,
        ]);

        return $event;
    }

    public function deactivate(Event $event, array $requestData, array $options): Event
    {
        $QueuedJobs = $this->fetchTable('Queue.QueuedJobs');

        $QueuedJobs->createJob(SetEmailTask::class, [
            'enable' => 0,
        ]);

        $QueuedJobs->createJob(SetPushTask::class, [
            'enable' => 0,
        ]);

        return $event;
    }

}
