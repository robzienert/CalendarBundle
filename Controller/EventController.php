<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="rizza_calendar_event")
     */
    public function listAction()
    {
        $events = $this->get('rizza_calendar.event_manager')->findEvents();

        return $this->render('RizzaCalendarBundle:Event:list.html.twig', array('events' => $events));
    }

    /**
     * @Route("/show/{id}", name="rizza_calendar_event_show")
     */
    public function showAction($id)
    {
        $event = $this->findEvent($id);

        return $this->render('RizzaCalendarBundle:Event:show.html.twig', array('event' => $event));
    }

    /**
     * @Route("/new", name="rizza_calendar_event_new")
     */
    public function newAction()
    {
        $form = $this->get('rizza_calendar.form.event');

        $form->process();

        return $this->render('RizzaCalendarBundle:Event:new.html.twig', array('form' => $form));
    }

    /**
     * @Route("/create", name="rizza_calendar_event_create")
     */
    public function createAction()
    {
        $form = $this->get('rizza_calendar.form.event');

        $process = $form->process();
        if ($process) {
            return $this->redirect($this->generateUrl('_rizza_calendar_event'));
        }

        return $this->render('RizzaCalendarBundle:Event:new.html.twig', array('form' => $form));
    }

    /**
     * @Route("/edit/{id}", name="rizza_calendar_event_edit")
     */
    public function editAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->get('rizza_calendar.form.event');

        $form->process($event);

        return $this->render('RizzaCalendarBundle:Event:edit.html.twig', array(
            'form' => $form,
            'title' => $event->getTitle(),
        ));
    }

    /**
     * @Route("/update/{id}", name="rizza_calendar_event_update")
     */
    public function updateAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->get('rizza_calendar.form.event');

        $process = $form->process($event);
        if ($process) {
            $eventUrl = $this->get('router')->generate('_rizza_calendar_event_show', array('id' => $event->getId()));
            return new RedirectResponse($eventUrl);
        }

        return $this->render('RizzaCalendarBundle:Event:edit.html.twig', array(
            'form' => $form,
            'title' => $event->getId(),
        ));
    }

    /**
     * @Route("/delete/{id}", name="rizza_calendar_event_delete")
     */
    public function deleteAction($id)
    {
        $event = $this->findEvent($id);
        $this->get('rizza_calendar.event_manager')->deleteEvent($event);

        return new RedirectResponse($this->get('router')->generate('_rizza_calendar_event'));
    }

    /**
     * Find an event by its id
     *
     * @param int $id
     * @return Rizza\CalendarBundle\Model\Event
     * @throws NotFoundHttpException if the event cannot be found
     */
    public function findEvent($id)
    {
        $event = null;
        if (!empty($id)) {
            $event = $this->get('rizza_calendar.event_manager')->findEventBy(array('id' => $id));
        }

        if (empty($event)) {
            throw new NotFoundHttpException(sprintf('The event "%d" does not exist', $id));
        }

        return $event;
    }
}