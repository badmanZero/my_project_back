<?php
namespace App\Controller;


use App\Entity\Type;
use App\Repository\TypeTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class TypeController extends ApiController
{
    /**
    * @Route("/types", methods="GET")
    */
    //public function index(ManagerRegistry $doctrine): Response
    public function index(TypeTaskRepository $typeRepository)
    {
        $types = $typeRepository->transformAll();
        return $this->respond($types);
    }

    
}
