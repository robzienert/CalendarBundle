<?php
namespace Rizza\CalendarBundle\Tests\Creator;

use Rizza\CalendarBundle\Blamer\EventBlamerInterface;
use Rizza\CalendarBundle\Creator\EventCreator;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */
class EventCreatorTest extends CalendarTestCase
{
    public function testCreate()
    {
        $event        = $this->getMockEvent();
        $eventBlamer  = $this->getMockEventBlamer_ExpectsBlame($event);
        $eventManager = $this->getMockEventManager_ExpectsAddEvent($event);

        $creator = $this->getCreator($eventManager, $eventBlamer);
        $this->assertTrue($creator->create($event), "Always return true");
    }

    /**
     * Returns the creator
     *
     * @param EventManagerInterface $eventManager The event manager
     * @param EventBlamerInterface  $eventBlamer  The event blamer
     *
     * @return \Rizza\CalendarBundle\Creator\EventCreator
     */
    protected function getCreator(EventManagerInterface $eventManager, EventBlamerInterface $eventBlamer)
    {
        return new EventCreator($eventManager, $eventBlamer);
    }
}