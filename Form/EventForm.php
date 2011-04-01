<?php

namespace Bundle\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Entity\EventManager;

class EventForm extends Form
{
    protected $eventManager;
    protected $request;

    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new TextareaField('descriptio'));
        $this->add(new TextareaField('expression'));
        $this->add(new TextField('category'));
        $this->add(new TextField('calendar'));
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function process(EventInterface $event = null)
    {
        if (null === $event) {
            $event = $this->eventManager->createEvent('');
        }

        $this->setData($event);

        if ('POST' == $this->request->getMethod()) {
            $this->bind($this->request);

            if ($this->isValid()) {
                $this->eventManager->updateEvent($event);
                return true;
            }
        }

        return false;
    }
}