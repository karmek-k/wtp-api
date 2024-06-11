<?php

namespace App\Controller;

use App\Service\VehicleProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    public function __construct(private VehicleProvider $vehicleProvider)
    {
    }

    #[Route('/vehicle', name: 'app_vehicle')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VehicleController.php',
        ]);
    }
}
