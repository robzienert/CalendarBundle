<?php

namespace Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventController extends Controller
{
    /**
     * Shows all events
     */
    public function listAction()
    {
        $events = $this->get('calendar.repository.event')->findAll();

        return $this->render('CalendarBundle:Event:list.php', array('events' => $events));
    }

    /**
     * Shows a single event
     */
    public function showAction()
    {
        $event = $this->findEvent($id);

        return $this->render('CalendarBundle:Event:show.php', array('event' => $event));
    }

    /**
     * Shows the event creation form
     */
    public function newAction()
    {
        $form = $this->createForm();

        return $this->render('CalendarBundle:Event:new.php', array('form' => $form));
    }

    /**
     * Creates an event and redirects to the show page or shows the creation
     * screen if it contains errors
     */
    public function createAction($id)
    {
        $form = $this->createForm();
        $form->bind($this->get('request')->get($form->getId()));

        if ($form->isValid()) {
            $this->get('Doctrine.ORM.DefaultEntityManager')->persist($form->getData());
            $this->get('Doctrine.ORM.DefaultEntityManager')->flush();

            $this->get('session')->setFlash('calendar_event_create/success', true);

            return $this->redirect($this->generateUrl('calendar_event_show', array('id' => $this->getData()->getId())));
        }

        return $this->render('CalendarBundle:Event:new.php', array('form' => $form));
    }

    /**
     * Shows the event edit form
     */
    public function editAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->createForm($event);

        return $this->render('CalendarBundle:Event:edit.php', array(
            'form' => $form,
            'id' => $id,
        ));
    }

    /**
     * Updates an existing event and redirects to the show page or shows the
     * update form if it contains errors
     */
    public function updateAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->createForm($event);
        $form->bind($this['request']->get($form->getId()));

        if ($form->isValid()) {
            $this->get('Doctrine.ORM.DefaultEntityManager')->persist($form->getData());
            $this->get('Doctrine.ORM.DefaultEntityManager')->flush();

            $this->get('session')->setFlash('calendar_event_show', array('id' => $form->getData()->getId()));
        }

        return $this->render('CalendarBundle:Event:edit.php', array('form' => $form, 'id' => $id));
    }

    /**
     * Deletes an existing event and redirects to the event list
     */
    public function deleteAction($id)
    {
        $event = $this->findEvent($id);

        $this->get('calendar.repository.event')->getObjectManager()->delete($event);
        $this->get('calendar.repository.event')->getObjectManager()->flush();

        $this->get('session')->setFlash('calendar_event_delete/success');

        return $this->redirect($this->generateUrl('calendar_event_list'));
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
            $event = $this->get('calendar.repository.event')->findOneById($id);
        }

        if (empty($event)) {
            throw new NotFoundHttpException(sprintf('The event "%d" does not exist', $id));
        }

        return $event;
    }

    /**
     * Creates an EventForm instance and returns it.
     *
     * @param Event $object
     * @return Bundle\CalendarBundle\Form\EventForm
     */
    protected function createForm($object = null)
    {
        $form = $this->get('calendar.form.event');
        if (null === $object) {
            $eventClass = $this->get('calendar.repository.event')->getObjectClass();
            $object = new $eventClass();
        }

        $form->setData($object);

        return $form;
    }
}