<?php

namespace App\EventSubscriber;

use App\Repository\WorkTimeRepository;
use App\Repository\VisitRepository;
use CalendarBundle\Entity\WorkTime;
use CalendarBundle\Entity\Visit;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $visitRepo;
    private $request;

    public function __construct(VisitRepository $visitRepo,  RequestStack $requestStack) 
    {
        $this->visitRepo = $visitRepo;
        $this->request = $requestStack->getCurrentRequest();
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {   
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();
        $id = $filters['id'];

        $visits = $this->visitRepo->findAllVisits($start,$end, $id);
        $title = 'ZAJĘTY';
        
        foreach ($visits as $visit) {
            $visitEvent = new Event(
                
                $title,
                $visit->getStart(),
                $visit->getEnd(),
            );

            $visitEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'darkred',
            ]);

            $calendar->addEvent($visitEvent);
        }
    }
}