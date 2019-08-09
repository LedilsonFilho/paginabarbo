<?php

namespace App\Controller;

use App\Entity\Servico;
use App\Helper\ExtratorDadosRequest;
use App\Helper\ServicoFactory;
use App\Repository\ServicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServicoController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ServicoRepository $repository,
        ServicoFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($entityManager, $repository, $factory, $extratorDadosRequest);
    } 

    function atualizaEntidadeExistente(int $id, $entidade)
    {
        /** @var Servico $entidadeExistente */
        $entidadeExistente = $this->repository->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException(); 
        }
       
        
        $entidadeExistente
            ->setData($entidade->getData())
            ->setProjeto($entidade->getProjeto())
            ->setDescricao($entidade->getDescricao())
            ->setFoto($entidade->getFoto())
            ->setCliente($entidade->getCliente())
            ->setLocal($entidade->getLocal())
            ->setCategoria($entidade->getCategoria());
             

        return $entidadeExistente;
       
    }

}
