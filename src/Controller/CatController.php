<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CatRepository;
use Symfony\Component\Serializer\SerializerInterface;

final class CatController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {

    }

    #[Route('/cat', name: 'app_cat')]
    public function index(CatRepository $cat): JsonResponse
    {
        return $this->json($cat->findAll(),200,[],['groups' => 'cat:readAll']);
    }
}
