<?php

namespace App\Controller;

use App\Repository\CampanaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CampanaController extends AbstractController
{

    public function __construct(private readonly CampanaRepository $campanaRepository)
    {
        // TODO: Implement __clone() method.
    }

    #[Route('/campana', name: 'app_campana')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CampanaController.php',
        ]);
    }

    public function teste(string $teste)
    {
        $campanas = $this->campanaRepository->findAll();

        return $teste;
    }
}
