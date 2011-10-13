<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Form\Type\CalendarType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CalendarController extends BaseController
{
    public function listAction()
    {
        $calendars = $this->getCalendarManager()->findAll();

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:list.html.twig', array(
            'calendars' => $calendars,
        ));
    }

    public function showAction($id)
    {
        $calendar = $this->getCalendarManager()->find($id);

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:show.html.twig', array(
            'calendar' => $calendar,
        ));
    }

    public function addAction(Request $request)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->createCalendar();
        $form = $this->getCalendarFormFactory()->createForm($calendar);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->addCalendar($calendar)) {
                // @todo Add flash
                return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.calendar.list')));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->find($id);
        $form = $this->getCalendarFormFactory()->createForm($calendar);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->updateCalendar($calendar)) {
                // @todo Add flash
                return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.calendar.list')));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:edit.html.twig', array(
            'form' => $form->createView(),
            'calendar' => $calendar,
        ));
    }

    public function deleteAction($id)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->find($id);

        $manager->removeCalendar($calendar);

        return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.calendar.list')));
    }

}