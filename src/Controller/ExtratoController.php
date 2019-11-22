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

class ExtratoController extends MainController
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
    
    /**
     * @Route("/extrato", name="extrato")
     */
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

        return $this->render('extrato/index.html.twig', [            
            'listacontacorrente' => $this->listacontacorrente(), 
            'listacentrodecustos' => $this->listacentrodecustos(),
            'listalancamento' => $this->listalancamento($request), 
            'filtroDataInicaial' => $datainicial,
            'filtroDataFinal' => $datafinal,
        ]);
    }
}
