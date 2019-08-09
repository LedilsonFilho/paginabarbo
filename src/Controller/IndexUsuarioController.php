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

class IndexUsuarioController extends MainController
{

    public function __construct(            
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,     
        UserRepository $userrepository
    ) {
        parent::__construct($contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository);     
          
    }
    

    public function listacontausuario(){
        $lista = $this->userrepository->findAll();
        return $lista;
    }
   
        public function index()
    {
        return $this->render('index_usuario/index.html.twig', [            
            'listacontausuario' => $this->listacontausuario(),
            'listacontacorrente' => $this->listacontacorrente(),
        ]);
    }
}
