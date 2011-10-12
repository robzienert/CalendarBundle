<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Form\Type\CalendarType;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;

class CalendarController extends Controller
{
    public function listAction()
    {
        $calendars = $this->getCalendarManager()->findAll();

        return $this->render('RizzaCalendarBundle:Calendar:list.html.twig', array('calendars' => $calendars));
    }

    public function showAction($id)
    {
        $calendar = $this->getCalendarManager()->find($id);

        return $this->render('RizzaCalendarBundle:Calendar:show.html.twig', array('calendar' => $calendar));
    }

    public function addAction(Request $request)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->createCalendar();
        $form = $this->createForm(new CalendarType(), $calendar);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->addCalendar($calendar)) {
                // @todo Add flash
                return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.calendar.list')));
            }
        }

        return $this->render('RizzaCalendarBundle:Calendar:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->find($id);
        $form = $this->createForm(new CalendarType(), $calendar);

        $request = $this->getRequest();
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $manager->updateCalendar($calendar)) {
                // @todo Add flash
                return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.calendar.list')));
            }
        }

        return $this->render('RizzaCalendarBundle:Calendar:edit.html.twig', array(
            'form' => $form->createView(),
            'calendar' => $calendar,
        ));
    }

    public function deleteAction($id)
    {
        $manager = $this->getCalendarManager();
        $calendar = $manager->find($id);

        $manager->removeCalendar($calendar);

        return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.calendar.list')));
    }

    /**
     * @return CalendarManagerInterface
     */
    protected function getCalendarManager()
    {
        return $this->container->get('rizza_calendar.manager.calendar');
    }
}