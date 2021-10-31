<?php

namespace App\Controller;

use App\Entity\ProjectDocuments;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectDocumentsController extends AbstractController
{
    #[Route('/project/documents/delete/{id}', name: 'project_doc_delete')]
    public function delete(ProjectDocuments $projectDocuments): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($projectDocuments);
        $em->flush();
        return $this->redirectToRoute('home');
    }
}
