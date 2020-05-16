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
    private $workTimeRepo;
    private $visitRepo;
    private $router;
    private $request;

    public function __construct(
        VisitRepository $visitRepo,
        UrlGeneratorInterface $router,
        RequestStack $requestStack
        
    ) {
        $this->visitRepo = $visitRepo;
        $this->router = $router;
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

        // $err = 'Zajęta';
        foreach ($visits as $visit) {
            // this create the events with your data (here booking data) to fill calendar
            $visitEvent = new Event(
                
                $title,
                $visit->getStart(),
                $visit->getEnd(),
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $wizytaEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'darkred',
            ]);
            // $wizytaEvent->addOption(
            //     'url',
            //     $this->router->generate('booking_show', [
            //         'id' => $booking->getId(),
            //     ])
            // );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($visitEvent);
        }
    }
}