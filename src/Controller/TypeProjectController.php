<?php

namespace App\Controller;

use App\Entity\TypeProject;
use App\Form\TypeProjectType;
use App\Repository\ProjectTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type_project')]
class TypeProjectController extends AbstractController
{
    #[Route('/', name: 'type_project_index', methods: ['GET'])]
    public function index(ProjectTypeRepository $projectTypeRepository): Response
    {
        return $this->render('type_project/index.html.twig', [
            'type_projects' => $projectTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_project_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $typeProject = new TypeProject();
        $form = $this->createForm(TypeProjectType::class, $typeProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeProject);
            $entityManager->flush();

            return $this->redirectToRoute('type_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_project/new.html.twig', [
            'type_project' => $typeProject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_project_show', methods: ['GET'])]
    public function show(TypeProject $typeProject): Response
    {
        return $this->render('type_project/show.html.twig', [
            'type_project' => $typeProject,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_project_edit', methods: ['GET','POST'])]
    public function edit(Request $request, TypeProject $typeProject): Response
    {
        $form = $this->createForm(TypeProjectType::class, $typeProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_project/edit.html.twig', [
            'type_project' => $typeProject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_project_delete', methods: ['POST'])]
    public function delete(Request $request, TypeProject $typeProject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeProject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeProject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_project_index', [], Response::HTTP_SEE_OTHER);
    }
}
