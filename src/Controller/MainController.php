<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ContaCorrenteRepository;
use App\Repository\CentroDeCustoRepository;
use App\Repository\LancamentoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AgendamentosRepository;
use App\Entity\Agendamentos;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;

use App\Repository\FluxoRepository;

class MainController extends AbstractController
{
    public function __construct(
        AgendamentosRepository $agendamentosRepository,            
        ContaCorrenteRepository $contacorrenterepository, 
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository,
        FluxoRepository $fluxorepository         
    ) {  
        $this->AgendamentosRepository = $agendamentosRepository;           
        $this->contacorrenterepository = $contacorrenterepository;
        $this->centrodecustorepository = $centrodecustorepository;
        $this->lancamentorepository =$lancamentorepository;   
        $this->userrepository =$userrepository;
        $this->fluxorepository =$fluxorepository;
              
    }

    public function listapendentes($tipo, $datainicial, $datafinal){        
        //$filtro = array('debito' => $tipo, 'previsao' => true);        
        $lista = $this->lancamentorepository->findPagarReceber($tipo, $datainicial, $datafinal);
        
        $saldoprevisao = 0;
        $saldoconsolidado = 0;
        $listavalida = array();
        foreach($lista as $item){            
            if ($item->getIdconta()->getId() != "35" and $item->getIdconta()->getId() != "34" ){ 
                array_push($listavalida, $item);       
                if($item->getprevisao() == 0){
                    $saldoconsolidado += $item->getvalor();
                }
                if($item->getprevisao() == 1){
                    $saldoprevisao += $item->getvalor();
                }
            }            
        }
        $total = $saldoconsolidado + $saldoprevisao;
        $listalancamento = array(
            'lista'=>$listavalida, 
            'saldoprevisao' => $saldoprevisao, 
            'saldoconsolidado' => $saldoconsolidado, 
            'total' => $total );
        
        return $listalancamento;

    }

    public function listalancamento(Request $request){  
        $datainicial = $request->request->get('datainicial');
        $datafinal = $request->request->get('datafinal');
        if ($datainicial == null){
            $datainicial = "2019-01-01";
        }
        if ($datafinal == null){
            $datafinal = date("Y-m-d");
        }
                
        $lista = $this->lancamentorepository->findBetweenDate($datainicial, $datafinal);   
        //$lista = $this->lancamentorepository->findBy([] ,['data' => 'DESC']); 
        return $lista;
    }       

    public function listacontacorrente(){ 
        $lista = $this->contacorrenterepository->findAll();

        $contas = array();
        foreach($lista as $item){
            array_push($contas,['id' => $item->getId(),'nome' => $item->getNome(), 'saldo' => $this->saldoconta($item->getId())]);            
        }
        return $contas;
    }   

    public function listasimplescontacorrente(){
        $lista = $this->contacorrenterepository->findAll();
        return $lista;
    }

    public function listacentrodecustos(){
        $lista = $this->centrodecustorepository->findAll();
        return $lista;
    }

    public function saldoconta($conta){        
        $filtro = array('idconta' => $conta);        
        $lista = $this->lancamentorepository->findBy($filtro);
        
        $saldo = 0;        
        foreach($lista as $item){
            if($item->getPrevisao() == false){
                if ($item->getDebito() == true){
                    $saldo -= $item->getValorpago();
                }elseif($item->getDebito() == false){
                    $saldo += $item->getValorpago();
                }
            }
        }         
        return $saldo; 
    }

    public function saldocentrodecusto($centrodecusto,  $mes, $ano){                  
        $lista = $this->lancamentorepository->findCentrodecustoByMonth($centrodecusto, $mes, $ano);        
        $saldo = 0;        
        foreach($lista as $item){
            if($item->getPrevisao() == false){
                if ($item->getDebito() == true){
                    $saldo -= $item->getValorpago();
                }elseif($item->getDebito() == false){
                    $saldo += $item->getValorpago();
                }
            }
        }         
        return $saldo;
    }
       
    public function graficoPie(Request $request){   
        $graficocc = $request->query->get('graficocc');             
        if ($graficocc == null){
            $graficocc = date("Y-m");
        }
        $data = explode("-", $graficocc);
        $mes = $data[1];
        $ano = $data[0];           
        $centrodecusto =  $this->listacentrodecustos();
        $labels = array();
        $valores = array();
        $cores = array();
        foreach($centrodecusto as $item){
            $labels[] = $item->getnome(); 
            $valores[] = $this->saldocentrodecusto($item->getId(), $mes, $ano);
            $r = intval((float)rand()/(float)getrandmax() * 255);
            $g = intval((float)rand()/(float)getrandmax() * 255);
            $b = intval((float)rand()/(float)getrandmax() * 255);
            array_push($cores, "rgb(".$r.", ".$g.", ".$b.")");
        }
       
        $graficopie = array(
            'labels'=>$labels, 
            'valores' => $valores, 
            'cores' => $cores
        );        
        return $graficopie;
    }

    public function graficoBarra(){  
        $arraydebito = array();
        $arraycredito = array();
        $arrayresultado = array();

        for ($i = 1; $i <= 12; $i++) {
            $debito = 0;
            $credito = 0;
            $resultado = 0;
            $lista = $this->lancamentorepository->findByMonth($i, '2019');
            foreach($lista as $item){
                if($item->getPrevisao() == false){
                    if ($item->getDebito() == true){
                        $debito += $item->getValorpago();
                    }elseif($item->getDebito() == false){
                        $credito += $item->getValorpago();
                    }
                }
           
            }
            $resultado = $credito - $debito;
            $arrayresultado[] = $resultado;
            $arraydebito[] = $debito;
            $arraycredito[] = $credito;           
        }        
       
        $graficopie = array(
            'arraydebito'=> $arraydebito, 
            'arraycredito' => $arraycredito, 
            'arrayresultado' => $arrayresultado
            
        );        
        return $graficopie;
    }

    public function listaagendamentos($tipo){        
        $filtro = array('tipo' => $tipo);        
        $lista = $this->AgendamentosRepository->findBy($filtro);
        
        $saldoprevisao = 0;
        $saldoconsolidado = 0;
        
        $total = $saldoconsolidado + $saldoprevisao;
        $lista = array(
            'lista'=>$lista, 
            'saldoprevisao' => $saldoprevisao, 
            'saldoconsolidado' => $saldoconsolidado, 
            'total' => $total );
        
        return $lista;

    }

    public function addagenda(Request $request) 
    {   
        if ($request->request->get('id') <> 0){
            $agenda = $this->AgendamentosRepository->find($request->request->get('id'));

        }else{
            $agenda = new Agendamentos();
        }

        $data = \DateTime::createFromFormat('Y-m-d', $request->request->get('data'));  
        $requestitens = $request->request->get('itens'); 
        $total = str_replace("," , ".", str_replace(".", "", $request->request->get('total'))); 
        echo $total;     
        
        $agenda->setData($data)
                ->setDescricao($request->request->get('descricao'))
                ->setTipo($request->request->get('tipo'))
                ->setTotal($total);       

        $itens = $requestitens;
        $iten = explode(",", $itens);

        $size = count($iten);

        for ($i = 0; $i < $size; $i++) {
            $itenadd = $this->lancamentorepository->find($iten[$i]);
            $agenda->addIten($itenadd);            
        }

        $this->entityManager->persist($agenda);       
        $this->entityManager->flush();   
        
        return $this->redirectToRoute('dashboard');    
       
    }

    public function removeagendamento(int $id): Response
    {       
        $agenda = $this->AgendamentosRepository->find($id);      
        $teste = $agenda->getItens();  

        echo count($teste);
        foreach ($teste as $value) { 
            echo $value->getId();          
            $agenda->removeIten($value);          
        }      
           
        $this->entityManager->persist($agenda);
        $this->entityManager->flush();   
        $agenda = $this->AgendamentosRepository->find($id);    
        $this->entityManager->remove($agenda); 
        $this->entityManager->flush(); 
        
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function listaitensagenda(int $id)
    {      
       if ($id <> 0){
        $agenda = $this->AgendamentosRepository->find($id);      
        $itens = $agenda->getItens(); 
    
        $lista = array(
            'lista'=>$itens, 
            'agenda' => $agenda 
             );
       }else{
        $lista = array(
            'lista'=>"", 
            'agenda' => array( 'id' => 0, 'data' => new DateTime(), 'descricao' => "", 'total' => "") 
             );

       }  
               
        return $lista;
    }


    public function graficoFluxo($id_conta, $mes){
        $arraydata = array();
        $arraydebito = array();
        $arraycredito = array();
        $arrayrsaldo = array();
        $SaldoGeral = $this->fluxorepository->SaldoGeral($id_conta, $mes);
        $Saldopendentes = $this->fluxorepository->Saldopendentes($id_conta);

        foreach($SaldoGeral as $item){ 
            foreach($item as $chave => $valor) {
                if($chave == "data"){                    
                    $arraydata[] = $valor;
                }elseif($chave == "saldo"){
                    $arrayrsaldo[] = $valor;
                }             
            }           
        }

        foreach($Saldopendentes as $item){ 
            foreach($item as $chave => $valor) {
                if($chave == "data"){                    
                    $arraydata[] = $valor;                   
                }elseif($chave == "credito"){
                    $arrayrsaldo[] = $valor;
                }elseif($chave == "debito"){
                    $arrayrsaldo[] = $valor;
                }              
            }           
        }

        $graficfluxo = array(
            'arraydata' => $arraydata,
            'arraydebito'=> $arraydebito, 
            'arraycredito' => $arraycredito, 
            'arraysaldo' => $arrayrsaldo
            
        );        
        return $graficfluxo;            
        
    }
}
