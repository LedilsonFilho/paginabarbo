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

class PrintController extends MainController
{
    public function __construct(            
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository       
    ) {  
        parent::__construct($contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository);          
            
    }

    /**
     * @Route("/print", name="print")
     */
    public function index(Request $request)
    {
        $datainicial = $request->request->get('datainicial');
        $datafinal = $request->request->get('datafinal');        
        $contacorrente_id = $request->query->get('contacorrenteid');

        if ($datainicial == null){
            $datainicial = "2019-01-01"; 
        }
        if ($datafinal == null){
            $datafinal = date("Y-m-d");
        }  

        return $this->render('print/index.html.twig', [
            'listacontacorrente' => $this->listacontacorrente(), 
            'listacentrodecustos' => $this->listacentrodecustos(),
            'listalancamento' => $this->listalancamento($request), 
            'filtroDataInicaial' => $datainicial,
            'filtroDataFinal' => $datafinal,
            'contacorrente_id' => $contacorrente_id,
        ]);
    }
}
