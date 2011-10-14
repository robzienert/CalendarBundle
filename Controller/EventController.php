<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Form\Type\EventType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EventController extends BaseController
{
    public function listAction()
    {
        $events = $this->getEventManager()->findAll();

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Event:list.html.twig', array(
            'events' => $events,
        ));
    }

    public function showAction($id)
    {
        $event = $this->getEventManager()->find($id);

        if (!$this->container->get('security.context')->isGranted('view', $event)) {
            throw new AccessDeniedException();
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Event:show.html.twig', array(
            'event' => $event,
        ));
    }

    public function addAction($calendarId, Request $request)
    {
        $calendar = $this->getCalendarManager()->find($calendarId);
        $manager = $this->getEventManager();
        $event = $manager->createEvent($calendar);

        if (!$this->container->get('security.context')->isGranted('create', $event) || !$this->container->get('security.context')->isGranted('edit', $calendar)) {
            throw new AccessDeniedException();
        }

        $form = $this->getEventFormFactory()->createForm($event);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->addEvent($event)) {
                // @todo add flash
                return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.event.list')));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Event:add.html.twig', array(
            'form' => $form->createView(),
            'calendar' => $calendar,
        ));
    }

    public function editAction($id, Request $request)
    {
        $manager = $this->getEventManager();
        $event = $manager->find($id);

        if (!$this->container->get('security.context')->isGranted('edit', $event)) {
            throw new AccessDeniedException();
        }

        $form = $this->getEventFormFactory()->createForm($event);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->updateEvent($event)) {
                // @todo add flash
                return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.event.list')));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Event:edit.html.twig', array(
            'form' => $form->createView(),
            'event' => $event,
        ));
    }

    public function deleteAction($id)
    {
        $manager = $this->getEventManager();
        $event = $manager->find($id);

        if (!$this->container->get('security.context')->isGranted('delete', $event)) {
            throw new AccessDeniedException();
        }

        $manager->removeEvent($event);

        return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.event.list')));
    }

}