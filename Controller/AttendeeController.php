<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AttendeeController extends BaseController
{

    public function listAction($eventId)
    {
        $event = $this->getEventManager()->find($eventId);
        $attendees = $event->getAttendees();

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Attendee:list.html.twig', array(
            'event' => $event,
            'attendees' => $attendees,
        ));
    }

    public function showAction($id)
    {
        $attendee = $this->getAttendeeManager()->find($id);

        if (!$this->container->get('security.context')->isGranted('view', $attendee)) {
            throw new AccessDeniedException();
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Attendee:show.html.twig', array(
            'attendee' => $attendee,
        ));
    }

    public function addAction($eventId, Request $request)
    {
        $event = $this->getEventManager()->find($eventId);
        $manager = $this->getAttendeeManager();
        $attendee = $manager->createAttendee($event);

        if (!$this->container->get('security.context')->isGranted('create', $attendee)) {
            throw new AccessDeniedException();
        }

        $form = $this->getAttendeeFormFactory()->createForm($attendee);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $this->container->get('rizza_calendar.creator.attendee')->create($attendee)) {
                return $this->createRedirect('attendee', 'show', array(
                    'id' => $attendee->getId(),
                ));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Attendee:add.html.twig', array(
            'form' => $form->createView(),
            'event' => $event,
        ));
    }

    public function editAction($id, Request $request)
    {
        $manager = $this->getAttendeeManager();
        $attendee = $manager->find($id);

        if (!$this->container->get('security.context')->isGranted('edit', $attendee)) {
            throw new AccessDeniedException();
        }

        $form = $this->getAttendeeFormFactory()->createForm($attendee);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->updateAttendee($attendee)) {
                return $this->createRedirect('attendee', 'show', array(
                    'id' => $attendee->getId(),
                ));
            }
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Attendee:edit.html.twig', array(
            'form' => $form->createView(),
            'attendee' => $attendee,
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $manager = $this->getAttendeeManager();
        $attendee = $manager->find($id);

        if (!$this->container->get('security.context')->isGranted('delete', $attendee)) {
            throw new AccessDeniedException();
        }

        if ('POST' === $request->getMethod()) {
            $manager->removeAttendee($attendee);

            return $this->createRedirect('attendee', 'list');
        }

        return $this->container->get('templating')->renderResponse('RizzaCalendarBundle:Attendee:delete.html.twig', array(
            'attendee' => $attendee,
        ));
    }

}
