<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UserService;

// Route prefix pour toutes les routes de ce contrôleur
#[Route('/user')]
final class UserController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em){

    }
    
    #[Route('/', name: 'app_user')]
    public function index(UserRepository $user): JsonResponse
    {
        $users = $user->findAll();
        $data = $this->serializer->normalize($users, 'json',['groups'=>'user_task:readAll']);
        //dd($data);
        if(empty($data)){
            return $this->json([
                'message' => 'No users found',
            ], 404);
        }
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'users' => $data,
        // ]);

        return $this->json([
            'message'=>'Requête Traitée',
            'content' => $user->findAll()
        ],200,[],['groups'=>'user_task:readAll']);
    }

    #[Route('/create', name:'app_user_create', methods:['POST'])]
    public function indexCreate(UserRepository $userRepo, Request $request):JsonResponse{
        
        //Je récupère les données de la requête
        $data = $request->getContent();

        //Je désérialise les données en un objet User
        $user = $this->serializer->deserialize($data,User::class,'json');

        //Je hash le mot de passe
        $password = password_hash($user->getMdpUser(),PASSWORD_DEFAULT);

        //Je remplace le mot de passe en clair par le mot de passe hashé
        $user->setMdpUser($password);

        // //Je persiste l'utilisateur en base de données
        $this->em->persist($user);

        // //J'exécute la requête
        $this->em->flush();

        //Message de Validation
        return $this->json(["mdp"=>$user->getMdpUser()]);
    }
}
