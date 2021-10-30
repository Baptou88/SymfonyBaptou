<?php


namespace App\Controller\api;



use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    #[Route('project/api/projects', name: 'api_projects')]
    public function index(Request $request, ProjectRepository $repository): JsonResponse
    {
        dump($request->get("q"));
        return $this->json($repository->search($request->get("q")));
    }
}