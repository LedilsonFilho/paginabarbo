<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ServicoRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexServicoController extends AbstractController
{

    public function __construct(            
        ServicoRepository $servicorepository
             
    ) {             
        $this->servicorepository = $servicorepository;
            
    }
    
    public function listaservicos(){ 
        $lista = $this->servicorepository->findAll();
           
        $listashopping = array();
        $listacomercial = array();
        $listaresidencial = array();
        $listatodos = array();
        $listaindustrial = array();
        foreach($lista as $item){
            array_push($listatodos, $item);
            if($item->getCategoria() == "comercial"){
                array_push($listacomercial, $item);
            }  
            if($item->getCategoria() == "shopping"){
                array_push($listashopping, $item);
            } 
            if($item->getCategoria() == "residencial"){
                array_push($listaresidencial, $item);
            }  
            if($item->getCategoria() == "industrial"){
                array_push($listaindustrial, $item);
            }        
        }
       
        $listalancamento = array(
            'listacomercial'=>$listacomercial, 
            'listashopping'=>$listashopping, 
            'listaresidencial'=>$listaresidencial, 
            'listaindustrial'=>$listaindustrial,
            'listatodos'=>$listatodos
            );
        
        return $listalancamento;

    }



    /**
     * @Route("/indexservico", name="indexservico")
     */
    public function index(Request $request, AuthenticationUtils $utils)
    {           
        $error = $utils->getLastAuthenticationError();
        $lastUserName = $utils->getLastUsername();

        $listaservicos = $this->listaservicos();
                
        return $this->render('index_servico/index.html.twig', [            
            'listacomercial' => $listaservicos['listacomercial'],
            'listaresidencial' => $listaservicos['listaresidencial'],
            'listashopping' => $listaservicos['listashopping'],
            'listaindustrial' => $listaservicos['listaindustrial'],
            'listaservicos' => $listaservicos['listatodos'],
            'error' => $error,
            'last_username' => $lastUserName
            
        ]);
    }
}
