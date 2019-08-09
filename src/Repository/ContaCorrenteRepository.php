<?php

namespace App\Repository;

use App\Entity\ContaCorrente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContaCorrente|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContaCorrente|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContaCorrente[]    findAll()
 * @method ContaCorrente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContaCorrenteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContaCorrente::class);
    }

    // /**
    //  * @return ContaCorrente[] Returns an array of ContaCorrente objects
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
    public function findOneBySomeField($value): ?ContaCorrente
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
