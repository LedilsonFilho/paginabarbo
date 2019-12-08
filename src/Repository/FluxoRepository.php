<?php

namespace App\Repository;

use App\Entity\Fluxo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class FluxoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fluxo::class);
    }

      
    public function SaldoGeral($idconta_id) 
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT data,
                SUM(IF(debito = 0, valorpago, 0)) AS credito,
                SUM(IF(debito = 1, valorpago, 0)) AS debito,
                (SELECT SUM(IF(debito = 0, valorpago, -valorpago)) FROM lancamento AS L2
                    WHERE lancamento.data >= L2.data AND idconta_id = :idconta_id AND previsao = 0
                ) AS saldo
            FROM lancamento
            WHERE idconta_id = :idconta_id AND previsao = 0 AND data BETWEEN DATE_SUB(curdate(), INTERVAL 1 MONTH) and curdate()
            GROUP BY DAY(data), MONTH(data), YEAR(data) 
            ORDER BY data ASC                     
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['idconta_id' => $idconta_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function Saldopendentes($idconta_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT data, 
            SUM(IF(debito = 0, valor, 0)) AS credito, 
            SUM(IF(debito = 1, valor, 0)) AS debito 
            FROM lancamento 
            WHERE idconta_id = :idconta_id AND previsao = 1 
            GROUP BY DAY(data), MONTH(data), YEAR(data) 
            ORDER BY data ASC                           
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['idconta_id' => $idconta_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }    
}
