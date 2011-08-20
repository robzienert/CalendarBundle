<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rizza\CalendarBundle\Entity\Event;
use Rizza\CalendarBundle\Form\Type\EventType;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="rizza_calendar_event_list")
     */
    public function listAction()
    {
        $events = $this->getRepository()->findAll();

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
     * @Route("/add", name="rizza_calendar_event_add")
     */
    public function addAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(new EventType(), $event);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($event);
                $em->flush();

                // @todo add flash
                return $this->redirect($this->generateUrl('rizza_calendar_event_list'));
            }
        }

        return $this->render('RizzaCalendarBundle:Event:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="rizza_calendar_event_edit")
     */
    public function editAction($id)
    {
        $event = $this->findEvent($id);
        $form = $this->createForm(new EventType(), $event);

        $request = $this->getRequest();
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($event);
                $em->flush();

                // @todo add flash
                return $this->redirect($this->generateUrl('rizza_calendar_event_list'));
            }
        }

        return $this->render('RizzaCalendarBundle:Event:edit.html.twig', array(
            'form' => $form->createView(),
            'event' => $event,
        ));
    }

    /**
     * @Route("/delete/{id}", name="rizza_calendar_event_delete")
     */
    public function deleteAction($id)
    {
        $event = $this->findEvent($id);

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($event);
        $em->flush();

        return $this->redirect($this->generateUrl('rizza_calendar_event_list'));
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
            $event = $this->getRepository()->findOneBy(array('id' => $id));
        }

        if (empty($event)) {
            throw new NotFoundHttpException(sprintf('The event "%d" does not exist', $id));
        }

        return $event;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('Rizza\CalendarBundle\Entity\Event');
    }
}