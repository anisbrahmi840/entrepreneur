<?php

namespace App\Repository;

use App\Entity\Entrepreneur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Entrepreneur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrepreneur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrepreneur[]    findAll()
 * @method Entrepreneur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepreneurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrepreneur::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Entrepreneur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Entrepreneur[] Returns an array of Entrepreneur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entrepreneur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function search($text)
    {
        $dd = $this->createQueryBuilder('e')
        ->andWhere('e.nom like :text OR e.prenom like :text OR e.cin like :text OR e.email like :text')
        ->setParameter('text', "%$text%")
        ;
        return $dd
            ->getQuery()
            ->getResult()
        ;
    }
}
