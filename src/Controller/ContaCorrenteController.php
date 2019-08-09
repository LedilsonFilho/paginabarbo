<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContaCorrenteRepository;
use App\Helper\ContaCorrenteFactory;
use App\Helper\ExtratorDadosRequest;
use App\Entity\ContaCorrente;

class ContaCorrenteController extends BaseController 
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ContaCorrenteRepository $repository,
        ContaCorrenteFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($entityManager, $repository, $factory, $extratorDadosRequest);
    }

    function atualizaEntidadeExistente(int $id, $entidade)
    {
        /** @var ContaCorrente $entidadeExistente */
        $entidadeExistente = $this->repository->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }

        $entidadeExistente
            ->setAg($entidade->getAg())
            ->setCc($entidade->getCc())
            ->setGerente($entidade->getGerente())
            ->setDescricao($entidade->getDescricao())
            ->setNome($entidade->getNome())
            ->setEndereco($entidade->getEndereco());

            

        return $entidadeExistente;
       
    }

    
}
