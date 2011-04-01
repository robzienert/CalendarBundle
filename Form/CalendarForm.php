<?php

namespace Rizza\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Model\CalendarInterface;
use Rizza\CalendarBundle\Entity\CalendarManager;

class CalendarForm extends Form
{
    protected $calendarManager;
    protected $request;

    public function configure()
    {
        $this->add(new TextField('name'));
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setCalendarManager(CalendarManager $calendarManager)
    {
        $this->calendarManager = $calendarManager;
    }

    public function process(CalendarInterface $calendar = null)
    {
        if (null === $calendar) {
            $calendar = $this->calendarManager->createCalendar('');
        }

        $this->setData($calendar);

        if ('POST' == $this->request->getMethod()) {
            $this->bind($this->request);

            if ($this->isValid()) {
                $this->calendarManager->updateCalendar($calendar);
                return true;
            }
        }

        return false;
    }
}