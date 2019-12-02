<?php

namespace App\Controller;

use App\Helper\EntidadeFactoryInterface;
use App\Helper\ExtratorDadosRequest;
use App\Helper\ResponseFactory;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;
use \DateInterval;

abstract class BaseController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var ObjectRepository
     */
    protected $repository;
    /**
     * @var EntidadeFactoryInterface
     */
    protected $factory;
    /**
     * @var ExtratorDadosRequest
     */
    private $extratorDadosRequest;

    public function __construct(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        EntidadeFactoryInterface $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    public function novo(Request $request): Response 
    {
        
        $corpoRequisicao = $request->getContent();
        $entidade = $this->factory->criarEntidade($request);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
            return new JsonResponse($entidade);
        }else{
            if ($request->get('_route') == "nova_Centro_de_Custo"){
                return $this->redirectToRoute('indexcentrodecusto');
            }elseif ($request->get('_route') == "nova_Conta_Corrente"){
                return $this->redirectToRoute('indexcontacorrente'); 
            }elseif ($request->get('_route') == "novo_lancamento"){
                return $this->redirectToRoute('fluxodecaixa'); 
            }elseif ($request->get('_route') == "novo_Usuarios"){
                return $this->redirectToRoute('indexusuarios'); 
            }elseif ($request->get('_route') == "novo_servico"){
                return $this->redirectToRoute('indexservico'); 
            }
        }     
        
    }

    public function buscarTodos(Request $request)
    {
        $filtro = $this->extratorDadosRequest->buscaDadosFiltro($request);
        $informacoesDeOrdenacao = $this->extratorDadosRequest->buscaDadosOrdenacao($request);
        [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscaDadosPaginacao($request);

        $lista = $this->repository->findBy(
            $filtro,
            $informacoesDeOrdenacao,
            $itensPorPagina,
            ($paginaAtual - 1) * $itensPorPagina
        );
        $fabricaResposta = new ResponseFactory(
            true,
            $lista,
            Response::HTTP_OK,
            $paginaAtual,
            $itensPorPagina
        );
        return $fabricaResposta->getResponse();
    }

    public function buscarUm(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $statusResposta = is_null($entidade)
            ? Response::HTTP_NO_CONTENT
            : Response::HTTP_OK;
        $fabricaResposta = new ResponseFactory(
            true,
            $entidade,
            $statusResposta
        );

        return $fabricaResposta->getResponse();
    }

    public function remove(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entidade = $this->factory->criarEntidade($request);

        try {
            $entidadeExistente = $this->atualizaEntidadeExistente($id, $entidade);
            $this->entityManager->flush();

            $fabrica = new ResponseFactory(
                true,
                $entidadeExistente,
                Response::HTTP_OK
            );
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
                return $fabrica->getResponse();
            }else{
                if ($request->get('_route') == "atualiza_Centro_de_Custo"){
                    return $this->redirectToRoute('indexcentrodecusto');
                }elseif ($request->get('_route') == "atualiza_Conta_Corrente"){
                    return $this->redirectToRoute('indexcontacorrente'); 
                }elseif ($request->get('_route') == "novo_lancamento"){
                    return $this->redirectToRoute('fluxodecaixa'); 
                }elseif ($request->get('_route') == "atualiza_lancamento"){ 
                    return $this->redirectToRoute('fluxodecaixa'); 
                }elseif ($request->get('_route') == "novo_Usuarios"){
                    return $this->redirectToRoute('indexusuarios'); 
                }elseif ($request->get('_route') == "novo_servico"){
                    return $this->redirectToRoute('indexservico'); 
                }elseif ($request->get('_route') == "atualiza_servico"){
                    return $this->redirectToRoute('indexservico'); 
                }elseif ($request->get('_route') == "baixa_lancamento"){
                    return $this->redirectToRoute('dashboard'); 
                }
                

            } 
            
        } catch (\InvalidArgumentException $ex) {
            $fabrica = new ResponseFactory(
                false,
                'Recurso não encontrado',
                Response::HTTP_NOT_FOUND
            );
            return $fabrica->getResponse();
        }
    }

    abstract function atualizaEntidadeExistente(int $id, $entidade);

    public function repete(Request $request): Response 
    {
        $repeticoes = $request->request->get('repetenuemrodevezes');
        // Data de ínicio 
        $date    = (new DateTime($request->request->get('data')));       
        
        for ($i = 0; $i < $repeticoes; $i++) {
            // Adiciona 2 meses a data
            $newDate = $date->add(new DateInterval('P'.$i.'M'));

            $entidade = array(
                'data' => $newDate->format('Y-m-d'),
                'descricao' => $request->request->get('descricao'),
                'previsao' => $request->request->get('previsao'),
                'valor' => str_replace(",", ".", str_replace(".", "", $request->request->get('valor'))),
                'dataedicao' => $request->request->get('dataedicao'),
                'idconta'=> $request->request->get('idconta'),
                'idcentrodecusto'=> $request->request->get('idcentrodecusto'),
                'userid_id'=> $request->request->get('userid_id'), 
                'debito' => $request->request->get('debito'),
                'notafiscal'=> $request->request->get('notafiscal'),
                'datapag'=> $request->request->get('datapag'),
                'valorpago'=> str_replace(",", ".", str_replace(".", "",$request->request->get('valorpago'))),
            );
            $json =  json_encode($entidade);

            $entidade = $this->factory->criarEntidade($json);

            $this->entityManager->persist($entidade);
            $this->entityManager->flush();
            
            $date = (new DateTime($request->request->get('data')));  

        }

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
            return new JsonResponse($entidade);
        }else{
            if ($request->get('_route') == "repete_lancamento"){
                return $this->redirectToRoute('indexpagarreceber');
            }
        }  
    }
}
