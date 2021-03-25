<?php
namespace Imefisto\ESHelpers\Domain\Event;

interface EventStore extends \Ddd\Application\EventStore
{
    public function getEventsFor($aggregateId);
}
