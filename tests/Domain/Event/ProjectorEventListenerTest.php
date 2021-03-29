<?php
namespace Imefisto\ESHelpers\Testing\Domain\Event;

use Ddd\Domain\DomainEventPublisher;
use Imefisto\ESHelpers\Domain\Event\ProjectorEventListener;

/**
 * @covers Imefisto\ESHelpers\Domain\Event\ProjectorEventListener
 */
class ProjectorEventListenerTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        $this->projector = new class
        {
            public $executedProjection = false;

            public function projectExampleEventOcurred($event)
            {
                $this->executedProjection = true;
            }
        };

        DomainEventPublisher::instance()->subscribe(
            new ProjectorEventListener($this->projector)
        );
    }

    /**
     * @test
     */
    public function testProjection()
    {
        DomainEventPublisher::instance()->publish(
            new ExampleEventOcurred('some-id')
        );

        $this->assertTrue($this->projector->executedProjection);
    }
}
