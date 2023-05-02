<?php

namespace App\Repository;

use App\Entity\SubTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubTask[]    findAll()
 * @method SubTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubTask::class);
    }

    public function transform(SubTask $subTask)
    {
        return [
                'id'    => (int) $subTask->getId(),
                'task' => (int) $subTask->getIdTask()->getId(),
                'note' => (string) $subTask->getNote(),
        ];
    }

    public function transformAll()
    {
        $subTask = $this->findAll();
        $subTaskArray = [];

        foreach ($subTask as $subTask) {
            $subTaskArray[] = $this->transform($subTask);
        }

        return $subTaskArray;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SubTask $entity, bool $flush = true): void
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
    public function remove(SubTask $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return SubTask[] Returns an array of SubTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubTask
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
