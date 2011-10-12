<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Form\Type\EventType;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Event:show.html.twig', array(
            'event' => $events,
        ));
    }

    public function addAction(Request $request)
    {
        $manager = $this->getEventManager();
        $event = $manager->createEvent();
        $form = $this->createForm(new EventType(), $event);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->addEvent($event)) {
                // @todo add flash
                return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.event.list')));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Event:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $manager = $this->getEventManager();
        $event = $manager->find($id);
        $form = $this->createForm(new EventType(), $event);

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

        $manager->removeEvent($event);

        return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('rizza_calendar.routing.event.list')));
    }

}