<?php

namespace App\Repository;

use App\Entity\AttestationFiscale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttestationFiscale|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationFiscale|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationFiscale[]    findAll()
 * @method AttestationFiscale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationFiscaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationFiscale::class);
    }

    // /**
    //  * @return AttestationFiscale[] Returns an array of AttestationFiscale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttestationFiscale
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
