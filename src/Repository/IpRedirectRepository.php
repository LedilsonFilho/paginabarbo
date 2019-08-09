<?php

namespace App\Repository;

use App\Entity\IpRedirect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IpRedirect|null find($id, $lockMode = null, $lockVersion = null)
 * @method IpRedirect|null findOneBy(array $criteria, array $orderBy = null)
 * @method IpRedirect[]    findAll()
 * @method IpRedirect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpRedirectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IpRedirect::class);
    }

    // /**
    //  * @return IpRedirect[] Returns an array of IpRedirect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IpRedirect
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
