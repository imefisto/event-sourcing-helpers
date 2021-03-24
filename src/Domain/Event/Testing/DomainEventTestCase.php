<?php
namespace Imefisto\ESHelpers\Domain\Event\Testing;

use Ddd\Domain\DomainEventPublisher;
use Imefisto\ESHelpers\Domain\Event\DomainEventAllListener;

abstract class DomainEventTestCase extends \PHPUnit\Framework\TestCase
{
    protected $listenerId;

    protected function setUp(): void
    {
        $this->listenerId = DomainEventPublisher::instance()->subscribe(
            new DomainEventAllListener
        );
    }

    protected function getListener()
    {
        return DomainEventPublisher::instance()->ofId($this->listenerId);
    }
}
