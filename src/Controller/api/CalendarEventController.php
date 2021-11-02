<?php

namespace App\Controller\api;

use App\Entity\CalendarEvent;
use App\Form\CalendarEventType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarEventController extends AbstractController
{



    #[Route('/api/maj_event/{id}','api/maj_event')]
    public function majEvent(CalendarEvent $event, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->name) && !empty($donnees->name) &&
            isset($donnees->startAt) && !empty($donnees->startAt) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->bgcolor) && !empty($donnees->bgcolor) &&
            isset($donnees->bordercolor) && !empty($donnees->bordercolor) &&
            isset($donnees->textcolor) && !empty($donnees->textcolor)
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$event){
                // On instancie un rendez-vous
                $calendar = new CalendarEvent();

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $event->setName($donnees->name);
            $event->setDescription($donnees->description);
            $event->setStartAt(new DateTime($donnees->startAt));
            if($donnees->allDay){
                $event->setEndAt(new DateTime($donnees->startAt));
            }else{
                $event->setEndAt(new DateTime($donnees->endAT));
            }
            $event->setAllDay($donnees->allDay);
            $event->setBgcolor($donnees->bgcolor);
            $event->setBorderColor($donnees->bordercolor);
            $event->setTextColor($donnees->textcolor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            // On retourne le code
            return new JsonResponse('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new JsonResponse('Données incomplètes', 404);
        }



    }
}