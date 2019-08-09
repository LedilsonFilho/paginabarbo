<?php


namespace App\Helper;


use App\Entity\CentroDeCusto;
use App\Repository\CentroDeCustoRepository;

class CentroDeCustoFactory implements EntidadeFactoryInterface
{
    

    public function __construct(        
        CentroDeCustoRepository $centroDeCustorepository)
    {        
        $this->CentroDeCustoRepository = $centroDeCustorepository;
    }
    public function criarEntidade($request)
    {

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
            $json = $request->getContent();
        }else{
            $entidade = array(
                'nome' => $request->request->get('nome'),                
                'descricao'=> $request->request->get('descricao'),
            );

            $json =  json_encode($entidade);
        
        };

        $dadosEmJson = json_decode($json);
        $nome = $dadosEmJson->nome;
        $descricao = $dadosEmJson->descricao;


        $centrodecusto = new CentroDeCusto();
        $centrodecusto
            ->setNome($dadosEmJson->nome)
            ->setDescricao($dadosEmJson->descricao);

        return $centrodecusto;
    }
}