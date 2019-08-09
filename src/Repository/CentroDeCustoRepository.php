<?php

namespace App\Repository;

use App\Entity\CentroDeCusto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CentroDeCusto|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentroDeCusto|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentroDeCusto[]    findAll()
 * @method CentroDeCusto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentroDeCustoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CentroDeCusto::class);
    }

    // /**
    //  * @return CentroDeCusto[] Returns an array of CentroDeCusto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CentroDeCusto
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
