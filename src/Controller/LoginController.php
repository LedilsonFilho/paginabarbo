<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {


        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
            $json = $request->getContent();
        }else{
            $entidade = array(
                'usuario' => $request->request->get('usuario'),
                'senha' => $request->request->get('senha'),
            );
            $json =  json_encode($entidade);        
        };


        $dadosEmJson = json_decode($json);


        if (is_null($dadosEmJson->usuario) || is_null($dadosEmJson->senha)) {
            return new JsonResponse([
                'erro' => 'Favor enviar usuário e senha'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->repository->findOneBy([
            'username' => $dadosEmJson->usuario
        ]);
        
        If ($user == null){
            return  new JsonResponse([
                'erro' => 'Usuário inválidos'
            ], Response::HTTP_UNAUTHORIZED);
        }else{
            if (!$this->encoder->isPasswordValid($user, $dadosEmJson->senha)) {
                return  new JsonResponse([
                    'erro' => 'Usuário ou senha inválidos'
                ], Response::HTTP_UNAUTHORIZED);
            }else{
                $token = JWT::encode(['username' => $user->getUsername()], 'B@r12bo16', 'HS256');

                if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
                    return new JsonResponse(['access_token' => $token]);  
                }else{
                    return $this->redirectToRoute('dashboard', array('access_token' => $token));  
                };
               
                          
            }
        }
        

        
    }
}
