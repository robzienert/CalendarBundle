<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Rizza\CalendarBundle\Form\CalendarContext;
use Rizza\CalendarBundle\Form\CalendarForm;

/**
 * @extra:Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * @extra:Route("/", name="_calendar")
     */
    public function listAction()
    {
        $calendars = $this->get('rizza_calendar.calendar_manager')->findCalendars();

        return $this->render('RizzaCalendar:Calendar:list.html.twig', array('calendars' => $calendars));
    }

    /**
     * @extra:Route("/show/:name", requirements={"name" = "\s+"}, name="_calendar_calendar_show")
     */
    public function showAction($name)
    {
        $calendar = $this->findCalendar($name);

        return $this->render('RizzaCalendar:Calendar:show.html.twig', array('calendar' => $calendar));
    }

    /**
     * @extra:Route("/new", name="_calendar_calendar_new")
     */
    public function newAction()
    {
        $form = $this->get('rizza_calendar.form.calendar');

        $form->process();

        return $this->render('RizzaCalendar:Calendar:new.html.twig', array('form' => $form));
    }

    /**
     * @extra:Route("/create", name="_calendar_calendar_create")
     */
    public function createAction()
    {
        $form = $this->get('rizza_calendar.form.calendar');

        $process = $form->process();
        if ($process) {
            return $this->redirect($this->generateUrl('_calendar'));
        }

        return $this->render('RizzaCalendar:Calendar:new.html.twig', array('form' => $form));
    }

    /**
     * @extra:Route("/edit/:name", name="_calendar_calendar_edit")
     */
    public function editAction($name)
    {
        $calendar = $this->findCalendar($name);
        $form = $this->get('rizza_calendar.form.calendar');

        $form->process($calendar);

        return $this->render('RizzaCalendar:Calendar:edit.html.twig', array(
            'form' => $form,
            'name' => $calendar->getName(),
        ));
    }

    /**
     * @extra:Route("/update/:name", name="_calendar_calendar_update")
     */
    public function updateAction($name)
    {
        $calendar = $this->findCalendar($name);
        $form = $this->get('rizza_calendar.form.calendar');

        $process = $form->process($calendar);
        if ($process) {
            $calendarUrl = $this->get('router')->generate('_calendar_calendar_show', array('name' => $calendar->getName()));
            return new RedirectResponse($calendarUrl);
        }

        return $this->render('RizzaCalendar:Calendar:edit.html.twig', array(
            'form' => $form,
            'name' => $calendar->getName(),
        ));
    }

    /**
     * @extra:Bundle("/delete/:name", name="_calendar_calendar_delete")
     */
    public function deleteAction($name)
    {
        $calendar = $this->findCalendar($name);
        $this->get('rizza_calendar.calendar_manager')->deleteCalendar($calendar);

        return new RedirectResponse($this->get('router')->generate('_calendar'));
    }

    /**
     * Find a calendar by its name
     *
     * @param string $name
     * @return Bundle\CalendarBundle\Model\CalendarInterface
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    protected function findCalendar($name)
    {
        $calendar = null;
        if (!empty($id)) {
            $calendar = $this->get('rizza_calendar.calendar_manager')->findCalendarBy(array('name' => $name));
        }

        if (empty($calendar)) {
            throw new NotFoundHttpException(sprintf('The calendar "%s" does not exist', $name));
        }

        return $calendar;
    }
}