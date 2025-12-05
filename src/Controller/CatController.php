<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CatRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cat;

#[Route('/cat')]
final class CatController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em)
    {

    }

    #[Route('/', name: 'app_cat')]
    public function index(CatRepository $cat): JsonResponse
    {
        return $this->json($cat->findAll(),200,[],['groups' => 'cat:readAll']);
    }

    #[Route('/create', name: 'app_cat_create', methods:'POST')]
    public function createCat(Request $request, CatRepository $catRepo): JsonResponse
    {
        //Récupérer les données de la requête
        $data = $request->getcontent();

        //Transformer le Json en Objet (deserialize)
        $cat = $this->serializer->deserialize($data, Cat::class, 'json');

        //Vérification si la categorie est dispo
        $catBDD = $catRepo->findBy(['name_cat' => $cat->getNameCat()]);
        
        if(!empty($catBDD)){
            return $this->json([
                'message' => 'La catégorie existe déjà',
                "code" => 409], 409);
        }

        //Persister mon objet
        $this->em->persist($cat);

        //Envoyer mon objet en BDD
        $this->em->flush();

        return $this->json([
            'message' => $cat->getNameCat().' a été enregistré', 
            "code" => 200], 200);
    }
}
