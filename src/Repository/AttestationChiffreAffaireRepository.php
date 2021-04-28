<?php

namespace App\Repository;

use App\Entity\AttestationChiffreAffaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttestationChiffreAffaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationChiffreAffaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationChiffreAffaire[]    findAll()
 * @method AttestationChiffreAffaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationChiffreAffaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationChiffreAffaire::class);
    }

    // /**
    //  * @return AttestationChiffreAffaire[] Returns an array of AttestationChiffreAffaire objects
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
    public function findOneBySomeField($value): ?AttestationChiffreAffaire
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
