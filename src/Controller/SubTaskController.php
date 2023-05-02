<?php
namespace App\Controller;


use App\Entity\SubTask;
use App\Repository\SubTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class SubTaskController extends ApiController
{
    /**
    * @Route("/subTasks", methods="GET")
    */
    public function index(SubTaskRepository $subTaskRepository)
    {
        $subTasks = $subTaskRepository->transformAll();
        return $this->respond($subTasks);
    }

    
}
