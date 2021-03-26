<?php
namespace Imefisto\ESHelpers\Domain\Event;

use Imefisto\ESHelpers\Domain\Event\EventStore;

class DomainEventAllListener implements \Ddd\Domain\DomainEventSubscriber
{
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function handle($aDomainEvent)
    {
        $this->eventStore->append($aDomainEvent);
    }

    public function isSubscribedTo($aDomainEvent)
    {
        return true;
    }

    public function getFirstEvent()
    {
        return $this->getEventAt(0);
    }

    public function getLastEvent()
    {
        $count = $this->countEvents();
        return $this->getEventAt($count - 1);
    }

    public function getEventAt($pos)
    {
        $count = $this->countEvents();
        return $count > 0 && $pos < $count
            ? $this->eventStore->events[$pos]
            : null
            ;
    }

    public function getEventsOfInstance($className)
    {
        return array_filter(
            $this->eventStore->events,
            function ($e) use ($className) {
                return get_class($e) == $className;
            }
        );
    }

    public function countEvents()
    {
        return count($this->eventStore->events);
    }

    public function countEventsOfInstance($className)
    {
        return count($this->getEventsOfInstance($className));
    }
}
