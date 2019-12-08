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
use App\Repository\AgendamentosRepository;
use App\Repository\FluxoRepository;

class DashboardController extends MainController
{

    /**
     * @var EntidadeFactoryInterface
     */
    protected $factory;

    public function __construct(
        AgendamentosRepository $agendamentosRepository,            
        ContaCorrenteRepository $contacorrenterepository,
        CentroDeCustoRepository $centrodecustorepository, 
        LancamentoRepository $lancamentorepository,
        UserRepository $userrepository,    
        FluxoRepository $fluxorepository    
    ) {  
        parent::__construct( $agendamentosRepository, $contacorrenterepository, $centrodecustorepository, $lancamentorepository, $userrepository, $fluxorepository);          
            
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

        $graficocc = $request->query->get('graficocc');  
        $graficoresultado = $request->query->get('ano');      
        if ($graficocc == null){
            $graficocc = date("Y-m");
        }
        if ($graficoresultado == null){
            $graficoresultado = date("Y");
        }   
        
        $chartpie = $this->graficoPie($request);
        $listapendentesCredito = $this->listapendentes(true, $datainicial, $datafinal);
        $listapendentesDebito = $this->listapendentes(false, $datainicial, $datafinal);
        $graficoBarra = $this->graficoBarra(); 
        $graficoFluxo = $this->graficoFluxo(31); 
        $listaagendamentocredito = $this->listaagendamentos(false);
        $listaagendamentosdebito = $this->listaagendamentos(true);
              
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
            'agendamentoscredito' => $listaagendamentocredito['lista'],
            'agendamentosdebito' => $listaagendamentosdebito['lista'],
            'graficoFluxoData' => $graficoFluxo['arraydata'],
            'graficoFluxoDebito' => $graficoFluxo['arraydebito'],
            'graficoFluxoCredito' => $graficoFluxo['arraycredito'],
            'graficoFluxoSaldo' => $graficoFluxo['arraysaldo'],
            
            
        ]);
    }
}
