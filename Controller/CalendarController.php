<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CalendarController extends BaseController
{
    public function listAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $calendars = $this->getCalendarManager()->findVisible($user);

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:list.html.twig', array(
            'calendars' => $calendars,
        ));
    }

    public function listEventsAction($id)
    {
        $calendar = $this->getCalendarManager()->find($id);

        if (!$this->container->get('security.context')->isGranted('view', $calendar)) {
            throw new AccessDeniedException();
        }

        $events = $calendar->getEvents();

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:listEvents.html.twig', array(
            'events' => $events,
            'calendar' => $calendar,
        ));
    }

    public function showAction($id)
    {
        $calendar = $this->getCalendarManager()->find($id);

        if (!$this->container->get('security.context')->isGranted('view', $calendar)) {
            throw new AccessDeniedException();
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:show.html.twig', array(
            'calendar' => $calendar,
        ));
    }

    public function addAction(Request $request)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->createCalendar();

        if (!$this->container->get('security.context')->isGranted('create', $calendar)) {
            throw new AccessDeniedException();
        }

        $form = $this->getCalendarFormFactory()->createForm($calendar);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $this->container->get('rizza_calendar.creator.calendar')->create($calendar)) {
                // @todo Add flash
                return $this->createRedirect('calendar', 'show', array(
                    'id' => $calendar->getId(),
                ));
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

        if (!$this->container->get('security.context')->isGranted('edit', $calendar)) {
            throw new AccessDeniedException();
        }

        $form = $this->getCalendarFormFactory()->createForm($calendar);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->updateCalendar($calendar)) {
                // @todo Add flash
                return $this->createRedirect('calendar', 'show', array(
                    'id' => $calendar->getId(),
                ));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:edit.html.twig', array(
            'form' => $form->createView(),
            'calendar' => $calendar,
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->find($id);

        if (!$this->container->get('security.context')->isGranted('delete', $calendar)) {
            throw new AccessDeniedException();
        }

        if ('POST' === $request->getMethod()) {
            $manager->removeCalendar($calendar);

            return $this->createRedirect('calendar', 'list');
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Calendar:delete.html.twig', array(
            'calendar' => $calendar,
        ));
    }

}