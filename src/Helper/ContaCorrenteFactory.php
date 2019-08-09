<?php


namespace App\Helper;


use App\Entity\ContaCorrente;
use App\Repository\ContaCorrenteRepository;

class ContaCorrenteFactory implements EntidadeFactoryInterface
{
    

    public function __construct(        
        ContaCorrenteRepository $contacorrenterepository)
    {        
        $this->contacorrenterepository = $contacorrenterepository;
    }
    public function criarEntidade($request)
    {

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
            $json = $request->getContent();
        }else{
            $entidade = array(
                'ag' => $request->request->get('ag'),
                'cc'=> $request->request->get('cc'),
                'gerente'=> $request->request->get('gerente'),
                'descricao'=> $request->request->get('descricao'),
                'nome'=> $request->request->get('nome'),
                'endereco'=> $request->request->get('endereco'),
            );

            $json =  json_encode($entidade);
        
        };

        $dadosEmJson = json_decode($json);
        
        $contacorrente = new ContaCorrente();
        $contacorrente
            ->setAg($dadosEmJson->ag)
            ->setCc($dadosEmJson->cc)
            ->setGerente($dadosEmJson->gerente)
            ->setDescricao($dadosEmJson->descricao)
            ->setNome($dadosEmJson->nome)
            ->setEndereco($dadosEmJson->endereco);

        return $contacorrente;
    }
}