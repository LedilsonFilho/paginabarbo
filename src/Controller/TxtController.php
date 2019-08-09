<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Helper\EntidadeFactoryInterface;
use App\Entity\Lancamento;
use App\Helper\LancamentoFactory;

class TxtController extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager,  
        LancamentoFactory $factory     
    ) {
        $this->entityManager = $entityManager;
        $this->factory = $factory;       
    }
    
    /**
     * @Route("/txt", name="txt")
     */
    public function index()
    {
        //$entidade = $this->factory->criarEntidade($request);

        //$this->entityManager->persist($entidade);
        //$this->entityManager->flush();

        //set_time_limit(0);
        $names=file('teste111.csv');
        // To check the number of lines 
        echo count($names).'<br>';
        foreach($names as $name)
        {
            $teste = explode(";", $name);
            echo $teste[3];

            
            $entidade1 = array(
                'descricao' => $teste[0],
                'data' => $teste[1],
                'datapag'=> $teste[2],
                'idconta'=> $teste[3],
                'valor' => str_replace(",", ".", str_replace(".", "", str_replace(" ", "", $teste[4]))),
                'valorpago'=> str_replace(",", ".", str_replace(".", "", str_replace(" ", "", $teste[5]))),
                'debito' => $teste[6],               
                'previsao' =>$teste[7],
                'idcentrodecusto'=> $teste[8],                
                'dataedicao' => $teste[9],
                'userid_id'=> $teste[10], 
                'notafiscal'=> "",
                
                
            );
            $entidade = $this->factory->criarEntidade($entidade1);
            $this->entityManager->persist($entidade);
            $this->entityManager->flush();  

            
        }

        return $this->render('txt/index.html.twig', [
            'controller_name' => 'TxtController',
        ]);
    }
}
