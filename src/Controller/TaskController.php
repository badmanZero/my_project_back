<?php
namespace App\Controller;


use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\StateRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\TypeTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class TaskController extends ApiController
{
    /**
    * @Route("/tasks", methods="GET")
    */
    //public function index(ManagerRegistry $doctrine): Response
    public function index(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->transformAll();
        return $this->respond($tasks);
    }

    /**
    * @Route("/tasks/{idTask}", methods="GET")
    */
    public function getTaskById($idTask, TaskRepository $taskRepository)
    {
        $task = $taskRepository->find($idTask);
        $task = $taskRepository->transformWithSubTask($task);
        return $this->respond($task);
    }

    /**
    * @Route("/tasks/state/{idState}", methods="GET")
    */
    //public function index(ManagerRegistry $doctrine): Response
    public function getTaskByState($idState, TaskRepository $taskRepository)
    {
        $etat = $idState;
        $tasks = $taskRepository->getAllByState($etat);
        //$tasks = $taskRepository->transformAll();
        return $this->respond($tasks);
    }

    /**
    * @Route("/tasks", methods="POST")
    */
    public function create(Request $request, TypeTaskRepository $typeRepository, TaskRepository $taskRepository, StateRepository $stateRepository, UtilisateurRepository $userRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get('name')) {
            return $this->respondValidationError('Please provide a name!');
        }

        $category = $stateRepository->find($request->get('etat'));
        if (! $category) {
            return $this->respondValidationError('l\'etat renseigné n\'est pas valide');
        }

        $affect = $userRepository->find($request->get('affectation'));
        if (! $affect) {
            return $this->respondValidationError('l\'affectation renseigné n\'est pas valide');
        }

        $type = $typeRepository->find($request->get('type'));
        if (! $type) {
            return $this->respondValidationError('le type renseigné n\'est pas valide');
        }
        
        $task = new Task;
        $task->setName($request->get('name'));
        $task->setDescription($request->get('description'));
        $task->setIdAffectation($affect);
        $task->setIdEtat($category);
        $task->setType($type);
    
        $em->persist($task);
        $em->flush();

        return $this->respondCreated($taskRepository->transform($task));
    }
}
