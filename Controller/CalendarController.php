<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Rizza\CalendarBundle\Entity\Calendar;
use Rizza\CalendarBundle\Form\Type\CalendarType;

class CalendarController extends Controller
{
    public function listAction()
    {
        $calendars = $this->getRepository()->findAll();

        return $this->render('RizzaCalendarBundle:Calendar:list.html.twig', array('calendars' => $calendars));
    }

    public function showAction($id)
    {
        $calendar = $this->findCalendar($id);

        return $this->render('RizzaCalendarBundle:Calendar:show.html.twig', array('calendar' => $calendar));
    }

    public function addAction(Request $request)
    {
        $calendar = new Calendar();
        $form = $this->createForm(new CalendarType(), $calendar);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($calendar);
                $em->flush();

                // @todo Add flash
                return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.calendar.list')));
            }
        }

        return $this->render('RizzaCalendarBundle:Calendar:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id)
    {
        $calendar = $this->findCalendar($id);
        $form = $this->createForm(new CalendarType(), $calendar);

        $request = $this->getRequest();
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($calendar);
                $em->flush();

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
        $calendar = $this->findCalendar($id);

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($calendar);
        $em->flush();

        return $this->redirect($this->generateUrl($this->container->getParameter('rizza_calendar.routing.calendar.list')));
    }

    /**
     * Find a calendar by its id
     *
     * @param string $id
     * @return Rizza\CalendarBundle\Model\CalendarInterface
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    protected function findCalendar($id)
    {
        $calendar = null;
        if (!empty($id)) {
            $calendar = $this->getRepository()->findOneBy(array('id' => $id));
        }

        if (empty($calendar)) {
            throw new NotFoundHttpException(sprintf('The calendar "%s" does not exist', $id));
        }

        return $calendar;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('Rizza\CalendarBundle\Entity\Calendar');
    }
}