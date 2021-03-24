<?php
namespace Imefisto\ESHelpers\Testing;

use Imefisto\ESHelpers\Domain\Event\DomainEventAllListener;
use Imefisto\ESHelpers\Domain\Event\Testing\DomainEventTestCase;

/**
 * @covers Imefisto\ESHelpers\Domain\Event\Testing\DomainEventTestCase
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
}
