<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Agendamentos;
use App\Entity\Lancamento;
use App\Repository\LancamentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContaCorrenteRepository;
use App\Repository\CentroDeCustoRepository;
use App\Repository\UserRepository;
use App\Repository\AgendamentosRepository;

class AgendamentosController extends MainController
{
    public function __construct(     
        EntityManagerInterface $entityManager, 
        AgendamentosRepository $agendamentosRepository,      
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository       
    ) {  
        $this->entityManager = $entityManager;
        parent::__construct($agendamentosRepository, $contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository);          
            
    }
   
    public function index(Request $request)
    {              
        $listapendentes = $this->listapendentes($request->query->get('debito'));       
        $listaitensagenda = $this->listaitensagenda($request->query->get('id'));

        return $this->render('agendamentos/index.html.twig', [
            'listacontacorrente' => $this->listacontacorrente(),    
            'listasimplescontacorrente' => $this->listasimplescontacorrente(),  
            'listapendentes' => $listapendentes['lista'],   
            'tipo' => $request->query->get('debito'),
            'listaitensagenda' => $listaitensagenda['lista'],
            'agendamento' => $listaitensagenda['agenda']
        ]); 
    }
    
    
}
