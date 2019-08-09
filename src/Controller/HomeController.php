<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\ServicoRepository;

class HomeController extends AbstractController
{
    public function __construct(            
        ServicoRepository $servicorepository
             
    ) {             
        $this->servicorepository = $servicorepository;
            
    }
    public function listaservicos(){
        $lista = $this->servicorepository->findAll();
        return $lista;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(AuthenticationUtils $utils) 
    {
        $error = $utils->getLastAuthenticationError();

        $lastUserName = $utils->getLastUsername();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'error' => $error,
            'last_username' => $lastUserName,
            'listaservicos' => $this->listaservicos()
        ]);
    }
}
