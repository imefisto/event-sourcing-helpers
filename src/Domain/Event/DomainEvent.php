<?php
namespace Imefisto\ESHelpers\Domain\Event;

use Ddd\Domain\DomainEvent as BaseDomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;

abstract class DomainEvent implements PublishableDomainEvent, BaseDomainEvent
{
    public function __construct($aggregateId, $payload = [], $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->payload = $payload;
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
