<?php
namespace Imefisto\ESHelpers\Domain\Event\Testing;

use Ddd\Domain\DomainEventPublisher;
use Imefisto\ESHelpers\Domain\Event\DomainEventAllListener;
use Imefisto\ESHelpers\Infrastructure\Persistence\InMemoryEventStore;

abstract class DomainEventTestCase extends \PHPUnit\Framework\TestCase
{
    protected $eventStore;
    protected $listenerId;

    protected function setUp(): void
    {
        $this->eventStore = $this->getEventStore();
        $this->listenerId = DomainEventPublisher::instance()->subscribe(
            new DomainEventAllListener($this->eventStore)
        );
    }

    protected function getListener()
    {
        return DomainEventPublisher::instance()->ofId($this->listenerId);
    }

    protected function getEventStore()
    {
        return $this->eventStore ?? new InMemoryEventStore;
    }
}
