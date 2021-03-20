<?php
namespace Imefisto\ESHelpers\Domain\Event;

use Verraes\ClassFunctions\ClassFunctions;
use Ddd\Domain\DomainEventPublisher;

abstract class IsEventSourced
{
    public function apply($event)
    {
        $method = 'apply' . ClassFunctions::short($event);
        $this->$method($event);
    }

    public function reconstitute(array $events)
    {
        foreach ($events as $event) {
            $this->apply($event);
        }
    }

    public function applyAndPublish($event)
    {
        $this->apply($event);
        DomainEventPublisher::instance()->publish($event);
    }
}
