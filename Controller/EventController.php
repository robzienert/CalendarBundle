<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @extra:Route("/event")
 */
class EventController extends Controller
{
    /**
     * @extra:Route("/", name="_calendar_event")
     */
    public function listAction()
    {
        $events = $this->get('rizza_calendar.event_manager')->findEvents();

        return $this->render('RizzaCalendar:Event:list.html.twig', array('events' => $events));
    }

    /**
     * @extra:Route("/show/{id}", name="_calendar_event_show")
     */
    public function showAction($id)
    {
        $event = $this->findEvent($id);

        return $this->render('RizzaCalendar:Event:show.html.twig', array('event' => $event));
    }

    /**
     * @extra:Route("/new", name="_calendar_event_new")
     */
    public function newAction()
    {
        $form = $this->get('rizza_calendar.form.event');

        $form->process();

        return $this->render('RizzaCalendar:Event:new.html.twig', array('form' => $form));
    }

    /**
     * @extra:Route("/create", name="_calendar_event_create")
     */
    public function createAction()
    {
        $form = $this->get('rizza_calendar.form.event');

        $process = $form->process();
        if ($process) {
            return $this->redirect($this->generateUrl('_calendar_event'));
        }

        return $this->render('RizzaCalendar:Event:new.html.twig', array('form' => $form));
    }

    /**
     * @extra:Route("/edit/{id}", name="_calendar_event_edit")
     */
    public function editAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->get('rizza_calendar.form.event');

        $form->process($event);

        return $this->render('RizzaCalendar:Event:edit.html.twig', array(
            'form' => $form,
            'title' => $event->getTitle(),
        ));
    }

    /**
     * @extra:Route("/update/{id}", name="_calendar_event_update")
     */
    public function updateAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->get('rizza_calendar.form.event');

        $process = $form->process($event);
        if ($process) {
            $eventUrl = $this->get('router')->generate('_calendar_event_show', array('id' => $event->getId()));
            return new RedirectResponse($eventUrl);
        }

        return $this->render('RizzaCalendar:Event:edit.html.twig', array(
            'form' => $form,
            'title' => $event->getId(),
        ));
    }

    /**
     * @extra:Bundle("/delete/{id}", name="_calendar_event_delete")
     */
    public function deleteAction($id)
    {
        $event = $this->findEvent($id);
        $this->get('rizza_calendar.event_manager')->deleteEvent($event);

        return new RedirectResponse($this->get('router')->generate('_calendar_event'));
    }

    /**
     * Find an event by its id
     *
     * @param int $id
     * @return Bundle\CalendarBundle\Model\Event
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