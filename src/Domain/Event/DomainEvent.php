<?php
namespace Imefisto\ESHelpers\Domain\Event;

use Ddd\Domain\DomainEvent as BaseDomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;

abstract class DomainEvent implements PublishableDomainEvent, BaseDomainEvent
{

    private readonly \DateTimeImmutable $occurredOn;

    public function __construct(
        private readonly string $aggregateId,
        private readonly array $payload = [],
        ?\DateTimeImmutable $occurredOn = null
    ) {
        $this->occurredOn = !is_null($occurredOn)
            ? $occurredOn
            : new \DateTimeImmutable
            ;
    }

    public function payload($field = null)
    {
        return is_null($field)
            ? $this->payload
            : (isset($this->payload[$field]) ? $this->payload[$field] : null)
            ;
    }

    public function occurredOn()
    {
        return $this->occurredOn->format('Y-m-d H:i:s');
    }

    public function aggregateId()
    {
        return $this->aggregateId;
    }
}
