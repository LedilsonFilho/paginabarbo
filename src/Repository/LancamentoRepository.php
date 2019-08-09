<?php

namespace App\Repository;

use App\Entity\Lancamento;
use App\Helper\ResponseFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface; 
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Lancamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lancamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lancamento[]    findAll()
 * @method Lancamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LancamentoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lancamento::class);
    }

    // /**
    //  * @return Lancamento[] Returns an array of Lancamento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l') 
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lancamento
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function updatecentrodecusto($idcentrodecusto, $lacamentoid)
    {
        $qb = $this->createQueryBuilder('u');
        $q = $qb->update()
                ->set('u.iccentrodecusto', '?1')                
                ->where('u.id = ?2')
                ->setParameter(1, $idcentrodecusto)
                ->setParameter(2, $lacamentoid)               
                ->getQuery();
        $p = $q->execute();
    }

    public function findByMonth($mes, $ano)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        //$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
            ->where('MONTH(c.datapag) = :month')           
            ->andWhere('YEAR(c.datapag) = :year');
            //->andWhere('DAY(p.dataReferencia) = :day'); 

        $qb->setParameter('month', $mes)            
            ->setParameter('year', $ano);
            //->setParameter('day', $day);


        $post = $qb->getQuery()->getResult();
        return $post;
    }

    public function findCentrodecustoByMonth($idCentrodecusto, $mes, $ano)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        //$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
            ->where('MONTH(c.datapag) = :month')           
            ->andWhere('YEAR(c.datapag) = :year')
            ->andWhere('c.iccentrodecusto = :idcc');

        $qb->setParameter('month', $mes)            
            ->setParameter('year', $ano)
            ->setParameter('idcc', $idCentrodecusto);


        $post = $qb->getQuery()->getResult();
        return $post;
    }

    public function findBetweenDate($datainicial, $datafinal)
    {
        //$emConfig = $this->getEntityManager()->getConfiguration();
        //$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        //$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        //$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.datapag >= :datainicial')
            ->andWhere('c.datapag <= :datafinal');
            //->andWhere('c.credito = :credito');
            

        $qb->setParameter('datainicial', $datainicial)
            ->setParameter('datafinal', $datafinal)            
            ->orderBy('c.datapag', 'ASC');
            //->setParameter('month', $month)
            //->setParameter('day', $day);


        $post = $qb->getQuery()->getResult();
        return $post;
    }
}
