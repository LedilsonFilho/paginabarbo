<?php

namespace App\Controller;

use App\Entity\Lancamento;
use App\Helper\ExtratorDadosRequest;
use App\Helper\LancamentoFactory;
use App\Repository\LancamentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LancamentoController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        LancamentoRepository $repository,
        LancamentoFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($entityManager, $repository, $factory, $extratorDadosRequest);
    } 

    public function transferencia(Request $request){
        $corpoRequisicao = $request->getContent();

        $arraydebito = array(
            'data' => $request->request->get('data'),
            'descricao' => $request->request->get('descricao'),
            'previsao' => 0,
            'valor' => str_replace(",", ".", str_replace(".", "", $request->request->get('valor'))),
            'dataedicao' => $request->request->get('dataedicao'),
            'idconta'=> $request->request->get('idcontaorigem'),
            'idcentrodecusto'=> $request->request->get('idcentrodecusto'),
            'userid_id'=> $request->request->get('userid_id'), 
            'debito' => 1,
            'notafiscal'=> '',
            'datapag'=> $request->request->get('data'),
            'valorpago'=> str_replace(",", ".", str_replace(".", "",$request->request->get('valor'))),            
        );

        $arraycredito = array(
            'data' => $request->request->get('data'),
            'descricao' => $request->request->get('descricao'),
            'previsao' => 0,
            'valor' => str_replace(",", ".", str_replace(".", "", $request->request->get('valor'))),
            'dataedicao' => $request->request->get('dataedicao'),
            'idconta'=> $request->request->get('idcontadestino'),
            'idcentrodecusto'=> $request->request->get('idcentrodecusto'),
            'userid_id'=> $request->request->get('userid_id'), 
            'debito' => 0,
            'notafiscal'=> '',
            'datapag'=> $request->request->get('data'),
            'valorpago'=> str_replace(",", ".", str_replace(".", "",$request->request->get('valor'))),            
        );

        $jsonarraydebito =  json_encode($arraydebito);
        $jsonarraycredito =  json_encode($arraycredito);

        $entidadedebito = $this->factory->criarEntidade($jsonarraydebito);
        $entidadecredito = $this->factory->criarEntidade($jsonarraycredito); 

        $this->entityManager->persist($entidadedebito);
        $this->entityManager->persist($entidadecredito);
        $this->entityManager->flush();
            
        return $this->redirectToRoute('fluxodecaixa');
        
    }

    function atualizaEntidadeExistente(int $id, $entidade)
    {
        /** @var Lancamento $entidadeExistente */
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
