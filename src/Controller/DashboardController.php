<?php

namespace App\Controller;

use App\Helper\EntidadeFactoryInterface;
use App\Repository\CentroDeCustoRepository;
use App\Repository\ContaCorrenteRepository;
use App\Repository\LancamentoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;

class DashboardController extends MainController
{

    /**
     * @var EntidadeFactoryInterface
     */
    protected $factory;

    public function __construct(            
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository       
    ) {  
        parent::__construct($contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository);          
            
    }    
    
    public function index(Request $request)
    {    

        $graficocc = $request->query->get('graficocc');  
        $graficoresultado = $request->query->get('ano');      
        if ($graficocc == null){
            $graficocc = date("Y-m");
        }
        if ($graficoresultado == null){
            $graficoresultado = date("Y");
        }   
        
        $chartpie = $this->graficoPie($request);
        $listapendentesCredito = $this->listapendentes(true);
        $listapendentesDebito = $this->listapendentes(false);
        $graficoBarra = $this->graficoBarra();
              
            return $this->render('dashboard/index.html.twig', [
            'listacontacorrente' => $this->listacontacorrente(),
            'listacentrodecustos' => $this->listacentrodecustos(),
            'lancamentodebito' => $listapendentesCredito['lista'], 
            'saldodebitoprevisao' => $listapendentesCredito['saldoprevisao'],
            'saldodebitoconsolidado' => $listapendentesCredito['saldoconsolidado'],
            'saldodebitotota' => $listapendentesCredito['total'],
            'lancamentocredito' => $listapendentesDebito['lista'],
            'saldocreditoprevisao' => $listapendentesDebito['saldoprevisao'],
            'saldocreditoconsolidado' => $listapendentesDebito['saldoconsolidado'],
            'saldocreditotota' => $listapendentesDebito['total'], 
            'chartbarAno' => $graficoresultado,
            'arrayDebito' => $graficoBarra['arraydebito'],
            'arrayCredito' => $graficoBarra['arraycredito'],
            'arrayResultado' => $graficoBarra['arrayresultado'],
            'chartpieMes' => $graficocc,
            'chartpieCores' =>  $chartpie['cores'],
            'chartpieValores' => $chartpie['valores'],
            'chartpieLabels' => $chartpie['labels'],
            
            
        ]);
    }
}
