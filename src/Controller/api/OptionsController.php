<?php


namespace App\Controller\api;


use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OptionsController extends AbstractController
{
    #[Route('/api/options', name:'api_options')]
    public function index(Request $request, OptionRepository $repository)
    {
        return $this->json($repository->search($request->query->get('q')));
    }
}