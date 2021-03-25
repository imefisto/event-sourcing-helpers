<?php
namespace Imefisto\ESHelpers\Testing;

use Imefisto\ESHelpers\Domain\Event\DomainEvent;
use Imefisto\ESHelpers\Infrastructure\Persistence\InMemoryEventStore;

/**
 * @covers Imefisto\ESHelpers\Domain\Event\DomainEvent
 * @covers Imefisto\ESHelpers\Infrastructure\Persistence\InMemoryEventStore
 */
class InMemoryEventStoreTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function testGetEventsFor()
    {
        $events = [
            $this->buildEvent('some-id', ['test' => 1]),
            $this->buildEvent('some-id2', ['test' => 2]),
        ];

        $eventStore = new InMemoryEventStore($events);
        $this->assertEquals(
            1,
            $eventStore->getEventsFor('some-id')[0]->payload('test')
        );
        $this->assertEquals(
            2,
            $eventStore->getEventsFor('some-id2')[0]->payload('test')
        );
    }

    /**
     * @test
     */
    public function testAppend()
    {
        $eventStore = new InMemoryEventStore();
        $eventStore->append(
            $this->buildEvent('test-append', ['test' => '123'])
        );

        $this->assertEquals(
            123,
            $eventStore->getEventsFor('test-append')[0]->payload('test')
        );
    }

    /**
     * @test
     */
    public function testAllStoredEventsSince()
    {
        $events = [
            $this->buildEvent('some-id', ['test' => 1]),
            $this->buildEvent('some-id2', ['test' => 2]),
            $this->buildEvent('some-id3', ['test' => 3]),
        ];

        $eventStore = new InMemoryEventStore($events);
        $result = $eventStore->allStoredEventsSince(1);
        $this->assertEquals(
            2,
            $result[0]->payload('test')
        );
        $this->assertEquals(
            3,
            $result[1]->payload('test')
        );
    }

    private function buildEvent($id, $payload)
    {
        return new class($id, $payload) extends DomainEvent {
        };
    }
}
