<?php

namespace Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CalendarController extends Controller
{
    /**
     * Shows all calendars
     */
    public function listAction()
    {
        $calendars = $this->get('calendar.repository.calendar')->findAll();

        return $this->render('CalendarBundle:Calendar:list.php', array('calendars' => $calendars));
    }

    /**
     * Shows a single calendar
     */
    public function showAction($id)
    {
        $calendar = $this->findCalendar($id);

        return $this->render('CalendarBundle:Calendar:show.php', array('calendar' => $calendar));
    }

    /**
     * Shows the calendar creation form
     */
    public function newAction()
    {
        $form = $this->createForm();

        return $this->render('CalendarBundle:Calendar:new.php', array('form' => $form));
    }

    /**
     * Creates a calendar and redirects to the show page or shows the creation
     * screen if it contains errors
     */
    public function createAction($id)
    {
        $form = $this->createForm();
        $form->bind($this->get('request')->get($form->getId()));

        if ($form->isValid()) {
            $this->get('Doctrine.ORM.DefaultEntityManager')->persist($form->getData());
            $this->get('Doctrine.ORM.DefaultEntityManager')->flush();

            $this->get('session')->setFlash('calendar_calendar_create/success', true);

            return $this->redirect($this->generateUrl('calendar_calendar_show', array('id' => $this->getData()->getId())));
        }

        return $this->render('CalendarBundle:Calendar:new.php', array('form' => $form));
    }

    /**
     * Shows the calendar edit form
     */
    public function editAction($id)
    {
        $calendar = $this->findCalendar($id);
        $form = $this->createForm($calendar);

        return $this->render('CalendarBundle:Calendar:edit.php', array(
            'form' => $form,
            'id' => $id,
        ));
    }

    /**
     * Updates an existing calendar and redirects to the show page or shows the
     * update form if it contains errors
     */
    public function updateAction($id)
    {
        $calendar = $this->findCalendar($id);
        $form = $this->createForm($calendar);
        $form->bind($this->get('request')->get($form->getId()));

        if ($form->isValid()) {
            $this->get('Doctrine.ORM.DefaultEntityManager')->persist($form->getData());
            $this->get('Doctrine.ORM.DefaultEntityManager')->flush();

            $this->get('session')->setFlash('calendar_calendar_update/success', true);

            return $this->redirect($this->generate('calendar_calendar_show', array('id' => $form->getData()->getId())));
        }

        return $this->render('CalendarBundle:Calendar:edit.php', array('form' => $form, 'id' => $id));
    }

    /**
     * Deletes an existing calendar and redirects to the calendar list
     */
    public function deleteAction($id)
    {
        $calendar = $this->findCalendar($id);

        $this->get('calendar.repository.calendar')->getObjectManager()->delete($calendar);
        $this->get('calendar.repository.calendar')->getObjectManager()->flush();

        $this->get('session')->setFlash('calendar_calendar_delete/success');

        return $this->redirect($this->generateUrl('calendar_calendar_list'));
    }

    /**
     * Find a calendar by its id
     *
     * @param int $id
     * @return Bundle\CalendarBundle\Model\Calendar
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    protected function findCalendar($id)
    {
        $calendar = null;
        if (!empty($id)) {
            $event = $this->get('calendar.repository.calendar')->findOneById($id);
        }

        if (empty($calendar)) {
            throw new NotFoundHttpException(sprintf('The calendar "%d" does not exist', $id));
        }

        return $calendar;
    }

    /**
     * Creates a CalendarForm instance and returns it.
     *
     * @param Calendar $object
     * @return Bundle\CalendarBundle\Form\CalendarForm
     */
    protected function createForm($object = null)
    {
        $form = $this->get('calendar.form.calendar');
        if (null === $object) {
            $calendarClass = $this->get('calendar.repository.calendar')->getObjectClass();
            $object = new $calendarClass();
        }

        $form->setData($object);

        return $form;
    }
}