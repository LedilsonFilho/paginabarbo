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

class AcertaCentroDeCustoController extends MainController
{
    public function __construct(            
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository       
    ) {  
        parent::__construct($contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository);          
            
    } 

    public function atualizacentrodecusto($idcentrodecusto, $lacamentoid){       
        $this->lancamentorepository->updatecentrodecusto($idcentrodecusto, $lacamentoid);
    }

    public function listalancamentotudo(){ 
        $filtro = array('iccentrodecusto' => 38);        
        $lista = $this->lancamentorepository->findBy($filtro, ['datapag' => 'DESC']);
        return $lista;
    }  

    /**
     * @Route("/acertacentrodecusto", name="acerta_centro_de_custo")
     */
    public function index(Request $request)
    {
        $idcentrodecusto = $request->query->get('idcentrodecusto');
        $lacamentoid = $request->query->get('lacamentoid');
        $this->atualizacentrodecusto($idcentrodecusto, $lacamentoid);


        return $this->render('acerta_centro_de_custo/index.html.twig', [
            'listacontacorrente' => $this->listacontacorrente(),
            'listacentrodecustos' => $this->listacentrodecustos(),
            'listalancamento' => $this->listalancamentotudo(),
        ]);
    }
}
