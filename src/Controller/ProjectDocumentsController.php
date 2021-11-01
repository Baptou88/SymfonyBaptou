<?php

namespace App\Controller;

use App\Entity\ProjectDocuments;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectDocumentsController extends AbstractController
{
    #[Route('/project/documents/delete/{id}', name: 'project_doc_delete',methods: "DELETE")]
    public function delete(ProjectDocuments $projectDocuments): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($projectDocuments);
        $em->flush();
//        return $this->redirectToRoute('home');
        return new JsonResponse(['success' =>1]);
    }
}
