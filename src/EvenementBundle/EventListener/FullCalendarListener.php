<?php

namespace  EvenementBundle\EventListener;

use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;
use EvenementBundle\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface ;
class FullCalendarListener
{


    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();


        $events = $this->em->getRepository("EvenementBundle:Evenement")->findAll();

        foreach ($events as $ev)
        {
            $calendar->addEvent(new Event(
                $ev->getTitre(),
                $ev->getDateDeb(),
                $ev->getDateFin()
            ));
        }




    }
}