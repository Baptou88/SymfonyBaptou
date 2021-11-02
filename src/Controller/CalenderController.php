<?php

namespace App\Controller;

use App\Repository\CalendarEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalenderController extends AbstractController
{
    #[Route('/calender', name: 'calender')]
    public function index(CalendarEventRepository $calender): Response
    {
        $events=[];
        foreach ($calender->findAll() as $event){
            $events[]= [
                'id' => $event->getId(),
                'start' => $event->getStartAt()->format('Y-m-d H:i:s'),
                'end' => $event->getEndAt()->format('Y-m-d H:i:s'),
                'title' => $event->getName(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBgcolor(),
                'textColor' => $event->getTextcolor(),
                'borderColor' => $event->getBordercolor(),
                'allDay' => $event->getAllDay(),

            ];
        }
        $data = json_encode($events);
        return $this->render('calender/index.html.twig', [
            'controller_name' => 'CalenderController',
            'data'=>$data
        ]);
    }
}
