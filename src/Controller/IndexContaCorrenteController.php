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


class IndexContaCorrenteController extends MainController
{
    public function __construct(  
        AgendamentosRepository $agendamentosRepository,      
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository       
    ) {  
        parent::__construct($agendamentosRepository, $contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository);          
            
    }
    
    
    public function index() 
    {
           
        return $this->render('index_conta_corrente/index.html.twig', [  
            'listacontacorrente' => $this->listacontacorrente(),    
            'listasimplescontacorrente' => $this->listasimplescontacorrente(),        
        ]);
    }
}
