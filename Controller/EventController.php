<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Entity\Event;
use Rizza\CalendarBundle\Form\Type\EventType;
use Rizza\CalendarBundle\Model\EventManagerInterface;

class EventController extends Controller
{
    public function listAction()
    {
        $events = $this->getEventManager()->findAll();

        return $this->render('RizzaCalendarBundle:Event:list.html.twig', array('events' => $events));
    }

    public function showAction($id)
    {
        $event = $this->getEventManager()->find($id);

        return $this->render('RizzaCalendarBundle:Event:show.html.twig', array('event' => $event));
    }

    public function addAction(Request $request)
    {
        $manager = $this->getEventManager();
        $event = $manager->createEvent();
        $form = $this->createForm(new EventType(), $event);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->addEvent($event)) {
                // @todo add flash
                return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.event.list')));
            }
        }

        return $this->render('RizzaCalendarBundle:Event:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $manager = $this->getEventManager();
        $event = $manager->find($id);
        $form = $this->createForm(new EventType(), $event);

        $request = $this->getRequest();
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->updateEvent($event)) {
                // @todo add flash
                return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.event.list')));
            }
        }

        return $this->render('RizzaCalendarBundle:Event:edit.html.twig', array(
            'form' => $form->createView(),
            'event' => $event,
        ));
    }

    public function deleteAction($id)
    {
        $manager = $this->getEventManager();
        $event = $manager->find($id);

        $manager->removeEvent($event);

        return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.event.list')));
    }

    /**
     * @return EventManagerInterface
     */
    protected function getEventManager()
    {
        return $this->container->get('rizza_calendar.manager.event');
    }
}