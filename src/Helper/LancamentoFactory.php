<?php


namespace App\Helper;


use App\Entity\Lancamento;
use App\Repository\UserRepository;
use App\Repository\ContaCorrenteRepository;
use App\Repository\CentroDeCustoRepository;

class LancamentoFactory implements EntidadeFactoryInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository, 
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centroDeCustorepository)
    {
        $this->UserRepository = $userRepository;
        $this->ContaCorrenteRepository = $contacorrenterepository;
        $this->CentroDeCustoRepository = $centroDeCustorepository;
    }
    public function criarEntidade($request)
    {           
        //$teste = json_decode($request);
        //$teste2 = false;
        //if (gettype($request) == 'string') {
            //$teste2 = true;;
        //}

        if (gettype($request) == 'string'){   
            $teste = json_decode($request);          
            $entidade = array(
                'data' => $teste->{'data'},
                'descricao' => $teste->{'descricao'},
                'previsao' => $teste->{'previsao'},
                'valor' => $teste->{'valor'},
                'dataedicao' => $teste->{'dataedicao'},
                'idconta'=> $teste->{'idconta'},
                'idcentrodecusto'=> $teste->{'idcentrodecusto'},
                'userid_id'=> $teste->{'userid_id'}, 
                'debito' => $teste->{'debito'},
                'notafiscal'=> $teste->{'notafiscal'},
                'datapag'=> $teste->{'datapag'},
                'valorpago'=> $teste->{'valorpago'},
            );
            $json =  json_encode($entidade); 

        }elseif (gettype($request) == 'object'){               
            
            $entidade = array(
                'data' => $request->request->get('data'),
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
            
        }elseif(gettype($request) == 'array'){
            $json =  json_encode($request);
        }
    

        $dadosEmJson = json_decode($json);
        $userId = $dadosEmJson->userid_id;
        $usuario = $this->UserRepository->find($userId);
        $data = \DateTime::createFromFormat('Y-m-d', $dadosEmJson->data);
        $dataedicao = \DateTime::createFromFormat('Y-m-d', $dadosEmJson->dataedicao);
        $datapag = ($dadosEmJson->datapag != "") ? \DateTime::createFromFormat('Y-m-d', $dadosEmJson->datapag) : null;
        $idconta = $dadosEmJson->idconta;
        $contacorrente = $this->ContaCorrenteRepository->find($idconta);
        $idccusto = $dadosEmJson->idcentrodecusto;
        $centrodecusto = $this->CentroDeCustoRepository->find($idccusto);
        

        $lancamento = new Lancamento();
        $lancamento
            ->setData($data)
            ->setDescricao($dadosEmJson->descricao)
            ->setPrevisao($dadosEmJson->previsao)
            ->setValor($dadosEmJson->valor)
            ->setDataedicao($dataedicao)
            ->setIdconta($contacorrente)
            ->setIccentrodecusto($centrodecusto)
            ->setUserid($usuario)
            ->setDebito($dadosEmJson->debito)
            ->setNotafiscal($dadosEmJson->notafiscal)
            ->setDatapag($datapag)
            ->setValorpago(($dadosEmJson->valorpago != "") ? $dadosEmJson->valorpago : null);

        return $lancamento;
    }
}