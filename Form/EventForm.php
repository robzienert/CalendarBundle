<?php

namespace Rizza\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\EntityChoiceField;
use Symfony\Component\Form\DateTimeField;
use Symfony\Component\Form\UrlField;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Model\Event;
use Rizza\CalendarBundle\Entity\EventManager;

class EventForm extends Form
{
    protected $eventManager;
    protected $request;
    protected $em;

    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new TextField('category'));
        $this->add(new DateTimeField('start_date'));
        $this->add(new DateTimeField('end_date'));
        $this->add(new TextareaField('description'));
        $this->add(new TextField('location'));
        $this->add(new UrlField('url', array(
            'default_protocol' => 'http'
        )));
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function process(EventInterface $event = null)
    {
        $this->postInjectionConfigure();

        if (null === $event) {
            $event = $this->eventManager->createEvent('');
            $event->setStatus(Event::STATUS_NONE);
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

    /**
     * Awesome hack to get around the fact configure() is called before the
     * DIC is able to inject the EntityManager.
     */
    protected function postInjectionConfigure()
    {
        $this->add(new EntityChoiceField('calendar', array(
            'em' => $this->em,
            'class' => 'Rizza\CalendarBundle\Entity\Calendar',
        )));
    }
}