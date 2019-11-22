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

class IndexCentroDeCustoController extends MainController 
{
    public function __construct(  
        AgendamentosRepository $agendamentosRepository,      
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository,
        FluxoRepository $fluxorepository      
    ) {  
        parent::__construct($agendamentosRepository, $contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository, $fluxorepository);          
            
    }  
   
    public function index()
    {
        return $this->render('index_centro_de_custo/index.html.twig', [
            'controller_name' => 'IndexCentroDeCustoController',
            'listacentrodecusto' => $this->listacentrodecustos(),
            'listacontacorrente' => $this->listacontacorrente(),
        ]);
    }
}
