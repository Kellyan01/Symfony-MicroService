<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Repository\CatRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;

#[Route('/task')]
final class TaskController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em){}

    #[Route('/', name: 'app_task')]
    public function index(TaskRepository $task): JsonResponse
    {
        //Récupération de toutes nos tâches
        $tasks = $task->findAll();

        //Sérialisation des données
        $data = $this->serializer->normalize($tasks, 'json',['groups'=>'task:readAll']);

        //dd($data);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TaskController.php',
            "tasks" => $data,
        ]);
    }

    #[Route('/create', name: 'app_task_create', methods: 'POST')]
    public function create_task(Request $request, UserRepository $userRepo, CatRepository $catRepo): JsonResponse {
        //Récupérer les données
        $data = $request->getContent();

        //Transformation mon JSON en Objet
        //Ici la deserialization n'est pas la méthode approprié, car elle n'accède pas aux Id du User du Cat imbriqué dans ma Task
        //$task = $this->serializer->deserialize($data, Task::class, 'json');

        //Solution : Passer par le decode() pour obtenir un tableau
        // Puis on va chercher l'objet User et l'objet Cat en BDD grâce à leur ID
        // Enfin, on recrée l'objet Task à la main, en lui passant grâce les Setter les données necessaire
        $task = $this->serializer->decode($data, 'json');

            //Récupération du user et du car via leur id dans la bdd
            $user = $userRepo->find($task['userTask']['id']); //objet User
            $cat = $catRepo->find($task['catTask']['id']); //objet Cat

            //Créer à la mano l'objet Task et lui donner toutes les données reçues grâce aux Setters
            $newTask = new Task();
            $newTask->setNameTask($task['nameTask'])
                ->setContentTask($task['contentTask'])
                ->setDateTask(new \DateTimeImmutable($task['dateTask']))
                ->setUserTask($user)
                ->setCatTask($cat);

        //Persister l'objet Task
        $this->em->persist($newTask);

        //lancer la requête
        $this->em->flush();

        return $this->json(['message' => $newTask->getNameTask().' a été enregistré', "code" => 200], 200);
    }

}
