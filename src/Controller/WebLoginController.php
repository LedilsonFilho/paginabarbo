<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\ServicoRepository;

class WebLoginController extends AbstractController
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
     * @Route("/weblogin", name="weblogin")
     */
    public function weblogin(Request $request, AuthenticationUtils $utils )
    {
        $error = $utils->getLastAuthenticationError();

        $lastUserName = $utils->getLastUsername();

        

        return $this->render('web_login/index.html.twig', [
            'error' => $error,
            'last_username' => $lastUserName,
            'listaservicos' => $this->listaservicos()
        ]);
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logout() 
    {

    }

}
