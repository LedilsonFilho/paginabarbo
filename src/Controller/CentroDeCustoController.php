<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CentroDeCustoRepository;
use App\Helper\CentroDeCustoFactory;
use App\Helper\ExtratorDadosRequest;
use App\Entity\CentroDeCusto;



class CentroDeCustoController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        CentroDeCustoRepository $repository,
        CentroDeCustoFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($entityManager, $repository, $factory, $extratorDadosRequest);
    }

    function atualizaEntidadeExistente(int $id, $entidade)
    {
        /** @var CentroDeCusto $entidadeExistente */
        $entidadeExistente = $this->repository->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }

        $entidadeExistente

            ->setNome($entidade->getNome())
            ->setDescricao($entidade->getDescricao());

        return $entidadeExistente;
       
    }
    
    
}
