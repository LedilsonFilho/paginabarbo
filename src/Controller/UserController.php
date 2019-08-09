<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Helper\ExtratorDadosRequest;
use App\Helper\UserFactory;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $repository,
        UserFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($entityManager, $repository, $factory, $extratorDadosRequest);
    } 

    function atualizaEntidadeExistente(int $id, $entidade)
    {
        /** @var User $entidadeExistente */
        $entidadeExistente = $this->repository->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }

        $entidadeExistente
            ->setData($entidade->getData())
            ->setDescricao($entidade->getDescricao())
            ->setPrevisao($entidade->getPrevisao())
            ->setValor($entidade->getValor())
            ->setDataedicao($entidade->getDataedicao())
            ->setIdconta($entidade->getIdconta())
            ->setIccentrodecusto($entidade->getIccentrodecusto())
            ->setUserid($entidade->getUserid())
            ->setDebito($entidade->getDebito())
            ->setNotafiscal($entidade->getNotafiscal()) 
            ->setDatapag($entidade->getDatapag())
            ->setValorpago($entidade->getValorpago()); 

        return $entidadeExistente;
       
    }
    
}
