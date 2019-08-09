<?php

namespace App\Repository;

use App\Entity\IpRed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IpRed|null find($id, $lockMode = null, $lockVersion = null)
 * @method IpRed|null findOneBy(array $criteria, array $orderBy = null)
 * @method IpRed[]    findAll()
 * @method IpRed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpRedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IpRed::class);
    }

    // /**
    //  * @return IpRed[] Returns an array of IpRed objects
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
    public function findOneBySomeField($value): ?IpRed
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
