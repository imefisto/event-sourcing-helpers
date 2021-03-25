<?php
namespace Imefisto\ESHelpers\Infrastructure\Persistence;

use Imefisto\ESHelpers\Domain\Event\EventStore;

class InMemoryEventStore implements EventStore
{
    public function __construct(array $events = [])
    {
        $this->events = $events;
    }

    public function append($aDomainEvent)
    {
        if (empty($aDomainEvent->aggregateId())) {
            throw new \RuntimeException('Aggregate id can not be empty');
        }

        $this->events[] = $aDomainEvent;
    }

    public function allStoredEventsSince($anEventId = 0)
    {
        return array_slice(
            $this->events,
            $anEventId
        );
    }

    public function getEventsFor($aggregateId)
    {
        $result = array_filter(
            $this->events,
            function ($e) use ($aggregateId) {
                return $e->aggregateId() == $aggregateId;
            }
        );

        return array_values($result);
    }
}
