<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rizza\CalendarBundle\Form\CalendarContext;
use Rizza\CalendarBundle\Form\CalendarForm;

class CalendarController extends Controller
{
    /**
     * @extra:Route("/", name="_calendar")
     * @return Response
     */
    public function listAction()
    {
        $calendars = $this->getRepository()->findAll();

        return $this->render('RizzaCalendar:Calendar:list.html.twig', array('calendars' => $calendars));
    }

    /**
     * @extra:Route("/show", name="_calendar_calendar_show")
     * @return Response
     */
    public function showAction($id)
    {
        $calendar = $this->findCalendar($id);

        return $this->render('RizzaCalendar:Calendar:show.html.twig', array('calendar' => $calendar));
    }

    /**
     * @extra:Route("/new", name="_calendar_calendar_new")
     * @return Response
     */
    public function newAction()
    {
        $form = $this->createForm();

        return $this->render('RizzaCalendar:Calendar:new.html.twig', array('form' => $form));
    }

    /**
     * @extra:Route("/create", name="_calendar_calendar_create")
     * @return Response
     */
    public function createAction()
    {
        $form = $this->createForm();

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('calendar_calendar_list'));
        }

        return $this->render('RizzaCalendar:Calendar:new.html.twig', array('form' => $form));
    }

    /**
     * Shows the calendar edit form
     */
    public function editAction($id)
    {
        $calendar = $this->findCalendar($id);
        $form = $this->createForm($calendar);

        return $this->render('RizzaCalendar:Calendar:edit.html.twig', array(
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

        return $this->render('RizzaCalendar:Calendar:edit.html.twig', array('form' => $form, 'id' => $id));
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
     * Returns the Calendar Entity Repository
     *
     * @return Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->get('doctrine.orm.entity_manager')->getRepository('Rizza\CalendarBundle\Entity\Calendar');
    }

    /**
     * Creates a CalendarForm instance and returns it.
     *
     * @return Bundle\CalendarBundle\Form\CalendarForm
     */
    protected function createForm($object = null)
    {
        $context = new CalendarContext($this->get('form.context')->getOptions());
        $form = CalendarForm::create($context, 'calendar');

        $form->bind($this->get('request'), $context);

        return $form;
    }
}