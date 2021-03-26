<?php
namespace Imefisto\ESHelpers\Testing;

use Ddd\Domain\DomainEventPublisher;
use Imefisto\ESHelpers\Domain\Event\DomainEvent;
use Imefisto\ESHelpers\Domain\Event\DomainEventAllListener;
use Imefisto\ESHelpers\Domain\Event\EventStore;
use Imefisto\ESHelpers\Domain\Event\Testing\DomainEventTestCase;

/**
 * @covers Imefisto\ESHelpers\Domain\Event\DomainEvent
 * @covers Imefisto\ESHelpers\Domain\Event\DomainEventAllListener
 * @covers Imefisto\ESHelpers\Domain\Event\Testing\DomainEventTestCase
 * @covers Imefisto\ESHelpers\Infrastructure\Persistence\InMemoryEventStore
 */
class SomeTest extends DomainEventTestCase
{
    /**
     * @test
     */
    public function canReturnAListener()
    {
        $this->assertInstanceOf(
            DomainEventAllListener::class,
            $this->getListener()
        );
    }

    /**
     * @test
     */
    public function canReturnAnEventStore()
    {
        $this->assertInstanceOf(
            EventStore::class,
            $this->getEventStore()
        );
    }

    /**
     * @test
     */
    public function publishedEventsAreSavedToEventStore()
    {
        DomainEventPublisher::instance()->publish(
            $this->buildEvent('some-id', ['test' => 1])
        );

        $this->assertEquals(
            1,
            $this->getEventStore()
                 ->getEventsFor('some-id')[0]
                 ->payload('test')
        );
    }

    /**
     * @test
     */
    public function publishedEventsAreCountedOnListener()
    {
        DomainEventPublisher::instance()->publish(
            $this->buildEvent('some-id', ['test' => 1])
        );

        $this->assertEquals(
            1,
            $this->getListener()
                 ->countEvents()
        );
    }

    /**
     * @test
     */
    public function publishedEventsCanBeFilteredByClass()
    {
        $event = $this->buildEvent('some-id', ['test' => 1]);

        DomainEventPublisher::instance()->publish($event);

        $this->assertSame(
            $event,
            $this->getListener()->getEventsOfInstance(get_class($event))[0]
        );
    }

    /**
     * @test
     */
    public function publishedEventsCanBeGetByPosition()
    {
        $event = $this->buildEvent('some-id', ['test' => 1]);

        DomainEventPublisher::instance()->publish($event);

        $this->assertSame(
            $event,
            $this->getListener()->getEventAt(0)
        );
    }

    private function buildEvent($id, $payload)
    {
        return new class($id, $payload) extends DomainEvent {
        };
    }
}
