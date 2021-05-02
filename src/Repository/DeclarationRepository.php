<?php

namespace App\Repository;

use App\Entity\Declaration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Declaration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Declaration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Declaration[]    findAll()
 * @method Declaration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Declaration::class);
    }

    // /**
    //  * @return Declaration[] Returns an array of Declaration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function encours($value, $date): ?Declaration
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.entrepreneur = :val')
            ->andWhere(":date between d.date_cr and d.date_ex")
            ->andWhere("d.etat = false")
            ->setParameter('val', $value)
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function regulariser($value, $date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.entrepreneur = :val')
            ->andWhere(":date > d.date_ex")
            ->andWhere("d.etat = false")
            ->setParameter('val', $value)
            ->setParameter('date', $date)
            ->orderBy('d.date_cr', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
