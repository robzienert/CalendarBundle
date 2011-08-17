<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rizza\CalendarBundle\Entity\Calendar;
use Rizza\CalendarBundle\Form\Type\CalendarType;



/**
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * @Route("/", name="rizza_calendar_list")
     */
    public function listAction()
    {
        $calendars = $this->get('rizza_calendar.calendar_manager')->findCalendars();

        return $this->render('RizzaCalendarBundle:Calendar:list.html.twig', array('calendars' => $calendars));
    }

    /**
     * @Route("/show/{name}", name="rizza_calendar_show")
     */
    public function showAction($name)
    {
        $calendar = $this->findCalendar($name);

        return $this->render('RizzaCalendarBundle:Calendar:show.html.twig', array('calendar' => $calendar));
    }

    /**
     * @Route("/add", name="rizza_calendar_add")
     */
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
                return $this->redirect($this->generateUrl('rizza_calendar_list'));
            }
        }

        return $this->render('RizzaCalendarBundle:Calendar:add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/edit/{name}", name="rizza_calendar_edit")
     */
    public function editAction($name)
    {
        $calendar = $this->findCalendar($name);
        $form = $this->get('rizza_calendar.form.calendar');

        $form->process($calendar);

        return $this->render('RizzaCalendarBundle:Calendar:edit.html.twig', array(
            'form' => $form,
            'name' => $calendar->getName(),
        ));
    }

    /**
     * @Route("/delete/{name}", name="rizza_calendar_delete")
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
     * @return Rizza\CalendarBundle\Model\CalendarInterface
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    protected function findCalendar($name)
    {
        $calendar = null;
        if (!empty($name)) {
            $calendar = $this->getDoctrine()
                ->getRepository('Rizza\CalendarBundle\Entity\Calendar')
                ->findOneBy(array('name' => $name));
        }

        if (empty($calendar)) {
            throw new NotFoundHttpException(sprintf('The calendar "%s" does not exist', $name));
        }

        return $calendar;
    }
}