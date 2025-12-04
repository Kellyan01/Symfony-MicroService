<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;
use Symfony\Component\Serializer\SerializerInterface;

final class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(TaskRepository $task, SerializerInterface $serializer): JsonResponse
    {
        //Récupération de toutes nos tâches
        $tasks = $task->findAll();

        //Sérialisation des données
        $data = $serializer->normalize($tasks, 'json',['groups'=>'task:readAll']);

        //dd($data);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TaskController.php',
            "tasks" => $data,
        ]);
    }
}
