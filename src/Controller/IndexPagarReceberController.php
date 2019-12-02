<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ContaCorrenteRepository;
use App\Repository\CentroDeCustoRepository;
use App\Repository\LancamentoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AgendamentosRepository;
use App\Repository\FluxoRepository;

class IndexPagarReceberController extends MainController
{
    public function __construct(  
        AgendamentosRepository $agendamentosRepository,      
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository,   
        FluxoRepository $fluxoRepository    
    ) {  
        parent::__construct($agendamentosRepository, $contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository, $fluxoRepository);          
            
    }

    public function index(Request $request)
    {
        $datainicial = $request->request->get('datainicial');
        $datafinal = $request->request->get('datafinal');
        if ($datainicial == null){
            $datainicial = "2019-01-01";
        }
        if ($datafinal == null){
            $datafinal = date("Y-m-d");           
        } 

        $listapendentesCredito = $this->listapendentes(true, $datainicial, $datafinal);
        $listapendentesDebito = $this->listapendentes(false, $datainicial, $datafinal);

        return $this->render('index_pagar_receber/index.html.twig', [
            'listacontacorrente' => $this->listacontacorrente(),    
            'listasimplescontacorrente' => $this->listasimplescontacorrente(),
            'lancamentodebito' => $listapendentesCredito['lista'],            
            'saldodebitotota' => $listapendentesCredito['total'],
            'lancamentocredito' => $listapendentesDebito['lista'],            
            'saldocreditotota' => $listapendentesDebito['total'],
            'filtroDataInicaial' => $datainicial,
            'filtroDataFinal' => $datafinal,  
            'listacentrodecustos' => $this->listacentrodecustos(),
        ]);
    }
}

