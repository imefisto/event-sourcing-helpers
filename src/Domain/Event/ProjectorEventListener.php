<?php
namespace Imefisto\ESHelpers\Domain\Event;

use Verraes\ClassFunctions\ClassFunctions;

class ProjectorEventListener implements \Ddd\Domain\DomainEventSubscriber
{
    public function __construct(private readonly mixed $projector)
    {
    }

    public function handle($aDomainEvent)
    {
        $method = 'project' . ClassFunctions::short($aDomainEvent);
        $this->projector->$method($aDomainEvent);
    }

    public function isSubscribedTo($aDomainEvent)
    {
        $method = 'project' . ClassFunctions::short($aDomainEvent);
        return method_exists($this->projector, $method);
    }
}
