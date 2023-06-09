<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function transformWithSubTask(Task $task)
    {
        return [
                'id'    => (int) $task->getId(),
                'name' => (string) $task->getName(),
                'description' => (string) $task->getDescription(),
                'affectation' => (String) $task->getIdAffectation()->getPrenom().' '.$task->getIdAffectation()->getNom(),
                'etat' => (string) $task->getIdEtat()->getName(),
                'type' => (string) $task->getType()->getName()
        ];
    }

    public function transform(Task $task)
    {
        return [
                'id'    => (int) $task->getId(),
                'name' => (string) $task->getName(),
                'description' => (string) $task->getDescription(),
                'affectation' => (String) $task->getIdAffectation()->getPrenom().' '.$task->getIdAffectation()->getNom(),
                'etat' => (string) $task->getIdEtat()->getName(),
                'type' => (string) $task->getType()->getName()
        ];
    }

    public function transformAll()
    {
        $tasks = $this->findAll();
        $tasksArray = [];

        foreach ($tasks as $task) {
            $tasksArray[] = $this->transform($task);
        }

        return $tasksArray;
    }

    public function getAllByState($etat)
    {
        $tasks = $this->findBy(array('idEtat' => $etat));
        $tasksArray = [];

        foreach ($tasks as $task) {
            $tasksArray[] = $this->transform($task);
        }

        return $tasksArray;
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Task $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Task $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
