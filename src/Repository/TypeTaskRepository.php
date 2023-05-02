<?php

namespace App\Repository;

use App\Entity\TypeTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTask[]    findAll()
 * @method TypeTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTask::class);
    }

    public function transform(TypeTask $type)
    {
        return [
                'id'    => (int) $type->getId(),
                'name' => (string) $type->getName()
        ];
    }

    public function transformAll()
    {
        $types = $this->findAll();
        $typesArray = [];

        foreach ($types as $type) {
            $typesArray[] = $this->transform($type);
        }

        return $typesArray;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TypeTask $entity, bool $flush = true): void
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
    public function remove(TypeTask $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return TypeTask[] Returns an array of TypeTask objects
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
    public function findOneBySomeField($value): ?TypeTask
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
