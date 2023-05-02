<?php
namespace App\Controller;


use App\Entity\State;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class StateController extends ApiController
{
    /**
    * @Route("/states", methods="GET")
    */
    //public function index(ManagerRegistry $doctrine): Response
    public function index(StateRepository $stateRepository)
    {
        $states = $stateRepository->transformAll();
        return $this->respond($states);
    }

    
}
