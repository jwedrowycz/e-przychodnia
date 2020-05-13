<?php

namespace App\EventSubscriber;

use App\Repository\CzasPracyRepository;
use App\Repository\WizytaRepository;
use CalendarBundle\Entity\CzasPracy;
use CalendarBundle\Entity\Wizyta;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $czasPracyRepo;
    private $wizytaRepo;
    private $router;
    private $request;

    public function __construct(
        WizytaRepository $wizytaRepo,
        UrlGeneratorInterface $router,
        RequestStack $requestStack
        
    ) {
        $this->wizytaRepo = $wizytaRepo;
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

        $wizyty = $this->wizytaRepo->findAllWizyta($start,$end, $id);
        

        // $err = 'Zajęta';
        foreach ($wizyty as $wizyta) {
            // this create the events with your data (here booking data) to fill calendar
            $wizytaEvent = new Event(
                $wizyta->getId(),
                $wizyta->getRozpoczecie(),
                $wizyta->getZakonczenie() // If the end date is null or not defined, a all day event is created.
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
            $calendar->addEvent($wizytaEvent);
        }
    }
}